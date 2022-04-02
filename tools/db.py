"""
:Name: VIU Project Database Tool
:Contributors: Zeke Critchlow
:DateModified: 2022-03-22

:Description: 
This support tool is for creating and initializing a database as well as reading
files in for data insertion. This tool can also rebuild the database to the initial start state
"""

# Standard Library Imports
import argparse
import os
import sys

# Third-Party Imports
import pymysql.cursors  # https://pypi.org/project/PyMySQL/


def parse_args() -> dict:
    """
    Collects and parses command-line arguments. Returns a dictionary of flag
    arguments as keys with their values

    :return: dictionary of arguments as keys with their associated values
    """
    # Collect arguments, create parser instance,  and parse CLI arguments
    parser = argparse.ArgumentParser()

    # Flag for rebuilding database
    parser.add_argument("-a", default=False, action='store_true',
                        help="Drop and rebuild entire database.")

    # Flag for dropping database
    parser.add_argument("-d", default=False, action='store_true',
                        help="Drop database.")

    # Flag for creating database
    parser.add_argument("-c", default=False, action='store_true',
                        help="Create database.")

    # Flag for initializing database schema
    parser.add_argument("-i", default=False, action='store_true',
                        help="Initialize database with schema.")

    # Flag for inserting data into database
    parser.add_argument("-l", default=False, action='store_true',
                        help="Load database with mock data.")

    # Filename and path of database schema
    parser.add_argument("--schema", default=None, type=str,
                        help="Path and filename to SQL file that describes database schema.")

    # Filename and path of data to insert into database
    parser.add_argument("--mock", default=None, type=str,
                        help="Path and filename to SQL file that inserts mock data.")

    # Filename and path of database info
    parser.add_argument("--dbinfo", default=None, type=str,
                        help="Path and filename to .inc file containing database info.")

    # Convert args namespace object to dictionary
    args = vars(parser.parse_args())

    # If '-a' is true, then set all other task flags to true
    if args['a']:
        args['d'] = True
        args['c'] = True
        args['i'] = True
        args['l'] = True

    return args


def parse_db_info(filepath: str) -> dict:
    """
    With the given filepath, checks for a .inc file, opens file for reading, and checks lines for target variables,
    then grabs variable vale and inserts into dictionary.

    :param path: target filename and leading path.

    :return: dictionary containing host information.
    """

    # Check if file exists
    if not os.path.exists(filepath):
        print(bcolors.FAIL + f"ERROR: DB info file does not exist! Check {filepath}" + bcolors.ENDC)
        return None;

    # Variable patterns to check for
    pat_host = '$host="'
    pat_user = '$user="'
    pat_password = '$password="'
    pat_database = '$database="'

    # Create dictionary
    db_info_dict = {
        "host": None,
        "user": None,
        "password": None,
        "database": None
    }

    # Open file for parsing
    try:
        with open(filepath) as reader:
            for line in reader:

                # Remove line's whitespace
                line = line.strip()
    
                # Check if line contains pattern
                if line[:len(pat_host)] == pat_host:
                    db_info_dict["host"] = (line[len(pat_host):-2])
                elif line[:len(pat_user)] == pat_user:
                    db_info_dict["user"] = (line[len(pat_user):-2])
                elif line[:len(pat_database)] == pat_database:
                    db_info_dict["database"] = (line[len(pat_database):-2])
                elif line[:len(pat_password)] == pat_password:
                    db_info_dict["password"] = (line[len(pat_password):-2])


            if db_info_dict["host"] is not None and db_info_dict["user"] is not None and db_info_dict["database"] is not None and db_info_dict["password"] is not None:
                return db_info_dict
            else:
                return None

    except Exception as e:

        print(bcolors.FAIL + "ERROR: ", end='')
        print(e)
        print(bcolors.ENDC, end='')
        return None
    
    return None


def open_connection(dbh: str, dbu: str, dbp: str, dbn: str) -> object:
    """
    Using parameters, creates a pymysql Connection object and returns it.

    :param dbh: host name of database server
    :param dbu: username credential for database server
    :param dbp: password credential for database server
    :param dbn: target name of database

    :return: Connection object if successful; otherwise, returns None
    """

    # Connect to the database server
    try:
        connection = pymysql.connect(host=dbh,
                                    user=dbu,
                                    password=dbp,
                                    database=dbn,
                                    cursorclass=pymysql.cursors.DictCursor)
    except Exception as e:

        print(bcolors.FAIL + "ERROR: ", end='')
        print(e)
        print(bcolors.ENDC, end='')
        return None

    else:
        if connection.open:
            print(bcolors.OKGREEN + f'SUCCESS: Connection open with host {dbh} in database {dbn}' + bcolors.ENDC)
            return connection
        else:
            return None
            


def create_database(connection: object, databaseName: str):
    """
    Creates database on connected server using passed database name

    :param connection: Connection object to target database creation with.
    "param databaseName: Name of database to create on target connection

    "return: True if successful; otherwise, returns false.
    """

    # Create database
    try:
        with connection:
            with connection.cursor() as cursor:

                sql = f"CREATE DATABASE {databaseName};"
                cursor.execute(sql)
                connection.commit()
                print(bcolors.OKGREEN + f"SUCCESS: CREATE DATABASE {databaseName};" + bcolors.ENDC)
                return True

    except Exception as e:

        print(bcolors.FAIL + "ERROR: ", end='')
        print(e)
        print(bcolors.ENDC, end='')
        return False


def drop_database(connection, databaseName):
    """
    Drops database on connected server using passed database name

    :param connection: Connection object to target database dropping with.
    "param databaseName: Name of database to drop on target connection

    "return: True if successful; otherwise, returns false.
    """

    # Drop database
    try:
        with connection:
            with connection.cursor() as cursor:

                sql = f"DROP DATABASE {databaseName};"
                cursor.execute(sql)
                connection.commit()
                print(bcolors.OKGREEN + f"SUCCESS: DROP DATABASE {databaseName};" + bcolors.ENDC)
                return True

    except Exception as e:

        print(bcolors.FAIL + "ERROR: ", end='')
        print(e)
        print(bcolors.ENDC, end='')
        return False


def select_database(connection, databaseName):
    """
    Selects database on connected server using passed database name

    :param connection: Connection object to target database selection with.
    "param databaseName: Name of database to select on target connection

    "return: True if successful; otherwise, returns false.
    """
    
    # Select target database
    try:
        with connection:

            connection.select_db(databaseName)
            print(bcolors.OKGREEN + f"SUCCESS: Database {databaseName} is now selected" + bcolors.ENDC)
            return True;

    except Exception as e:

        print(bcolors.FAIL + "ERROR: ", end='')
        print(e)
        print(bcolors.ENDC, end='')
        return False;


def read_in_file(connection, filepath):
    """
    Reads in passed file to the target connection. User should format target file to MySQL specifications.

    :param connection: Connection object to target database read-in with.
    "param databaseName: Name of database to read file to target connection

    "return: True if successful; otherwise, returns false.
    """

    # Check if file exists
    if not os.path.exists(filepath):
        print(bcolors.FAIL + f"ERROR: File does not exist! Check {filepath}" + bcolors.ENDC)
        return False;

    # Open file for parsing
    try:

        f = open(filepath,  'r')

        # Read-in and split into ';' delimited list
        req_list = f.read().split(';')
        req_list.pop()

        # Read list into connection
        print(f"Reading in file to database...")

        try:
            with connection:
                with connection.cursor() as cursor:

                    for idx, request in enumerate(req_list):
                        cursor.execute(request + ';')
                        connection.commit()
                    
                    print(bcolors.OKGREEN + f"SUCCESS: read {filepath} into database;" + bcolors.ENDC)
                    return True

        except Exception as e:

            print(bcolors.FAIL + "ERROR: ", end='')
            print(e)
            print(bcolors.ENDC, end='')
            return False;

    except Exception as e:

        print(bcolors.FAIL + "ERROR: ", end='')
        print(e)
        print(bcolors.ENDC, end='')
        return False;


def main():

    print(bcolors.HEADER + bcolors.BOLD)
    print(f'+==================================+')
    print(f'|      Database Support Tool       |')
    print(f'+==================================+')
    print(bcolors.ENDC)

    # Check if OS is Linux
    if sys.platform != 'linux':
        print(f"Current platform {sys.platform} is not Linux.\n\tExiting...")
        sys.exit()

    # Collect CLI arguments
    cli_args = parse_args()

    # Check if dbinfo file and path provided
    if cli_args['dbinfo'] is None:
        print(f'ERROR: No database inforfile specfified with --dbinfo argument. Please add path and filename to command.')
        sys.exit("Exiting...")

    # Collect host info from dbinfo file
    host_info = parse_db_info(cli_args['dbinfo'])

    # Check that all host info is provided
    if host_info is None:
        sys.exit(f'Host info not complete.\nExiting...')
    else:
        print(f'Host info collected.\nProceeding...')

    # Create connection with host
    connection = open_connection(host_info['host'], host_info['user'], host_info['password'], "")

    # Check if connection exists
    if connection is None:
        sys.exit(f'Could not open connection to host {host_info["host"]}.\nExiting...')

    # Drop database
    if cli_args['d']:
        print(bcolors.OKCYAN + f'Dropping {host_info["database"]}...' + bcolors.ENDC)
        status = drop_database(connection, host_info["database"])
        if not status:
            print(bcolors.FAIL + f'Failed to drop {host_info["database"]}.' + bcolors.ENDC)

    # Create database
    if cli_args['c']:
        print(bcolors.OKCYAN + f'Creating {host_info["database"]}...' + bcolors.ENDC)
        status = create_database(connection, host_info["database"])
        if not status:
            print(bcolors.FAIL + f'Failed to create {host_info["database"]}.' + bcolors.ENDC)

    # Initialize target database with schema
    if cli_args['schema'] is not None and cli_args['i']:
        status = select_database(connection, host_info["database"])
        if status:
            print(bcolors.OKCYAN + f'Initializing {host_info["database"]} with schema...' + bcolors.ENDC)
            status = read_in_file(connection, cli_args['schema'])
            if not status:
                print(bcolors.FAIL + f'Failed to initialize {host_info["database"]} with schema.' + bcolors.ENDC)

    # Insert data into target database
    if cli_args['mock'] is not None and cli_args['l']:
        status = select_database(connection, host_info["database"])
        if status:
            print(bcolors.OKCYAN + f'Inserting mock data into {host_info["database"]}...' + bcolors.ENDC)
            status = read_in_file(connection, cli_args['mock'])
            if not status:
                print(bcolors.FAIL + f'Failed to insert mock data into {host_info["database"]}' + bcolors.ENDC)

    # Done!
    sys.exit(f"Finished!\nExiting...")


class bcolors:
    HEADER = '\033[95m'
    OKBLUE = '\033[94m'
    OKCYAN = '\033[96m'
    OKGREEN = '\033[92m'
    WARNING = '\033[93m'
    FAIL = '\033[91m'
    ENDC = '\033[0m'
    BOLD = '\033[1m'
    UNDERLINE = '\033[4m'


if __name__ == '__main__':
    main()




# Standard Library Imports
import argparse
import os
import shutil
import subprocess
import sys
import getpass


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


def parse_args() -> dict:
    """
    Collects and parses command-line arguments. Returns a dictionary of flag
    arguments as keys with their values

    :return: dictionary of arguments as keys with their associated values
    """
    # Collect arguments, create parser instance,  and parse CLI arguments
    # args = sys.argv[1:]
    parser = argparse.ArgumentParser()
    parser.add_argument("--dest_dir", default=f"/home/student/{getpass.getuser()}/public_html/csci311/project", type=str,
                        help="Target directory to copy files to")
    parser.add_argument("--source_dir", default="../project", type=str,
                        help="Local directory to copy files from")

    # Convert args namespace object to dictionary
    args = vars(parser.parse_args())

    return args


def build_lists(path='.') -> (list, list):
    """
    Build two lists from the passed path; one a list of directories and the
    second a list of files and their paths.

    :param path: the target path to create list from
    :return: a tuple of lists, the first being files and the second a list of
        directories.
    """
    dirs_list = []
    files_list = []
    for root, dirs, files in os.walk(path):

        for d in dirs:
            dirs_list.append(f"{root}/{d}")
            # print(f"{root}/{d 
        for f in files:
            files_list.append(f"{root}/{f}")
            # print(f"{root}/{f}")

    files_list = sanitize_paths(files_list)
    dirs_list = sanitize_paths(dirs_list)

    return files_list, dirs_list


def add_dest_dir(target_list: list, path: str) -> list:
    new_list = []
    for item in target_list:
        new_list.append(f"{path}/{item}")
    return new_list


def sanitize_paths(paths_list: list) -> list:
    """
    Sanitizes paths held in passed list.

    :param paths_list: list of paths that need to be sanitized.
    :return: list of sanitized paths.
    """
    sanitized_list = []
    for item in paths_list:
        sanitized_list.append(item[2:])

    return sanitized_list


def main():
    """
    The main script function.

    :return:
    """

    # Check if OS is Linux
    if sys.platform != 'linux':
        print(f"Current platform {sys.platform} is not Linux.\n\tExiting...")
        sys.exit()

    # Collect CLI arguments
    cli_args = parse_args()

    # Change working directory and scan files/dirs
    os.chdir(cli_args["source_dir"])
    source_files, source_dirs = build_lists()

    # source_files = add_dest_dir(source_files, cli_args["dest_dir"])
    # source_dirs = add_dest_dir(source_dirs, cli_args["dest_dir"])

    print(bcolors.HEADER + "MAKING DIRS:" + bcolors.ENDC)
    for d in source_dirs:
        try:
            os.mkdir(f'{cli_args["dest_dir"]}/{d}')
            print(bcolors.OKGREEN + f'\t{cli_args["dest_dir"]}/{d}' + bcolors.ENDC)
        except OSError as e:
            print(bcolors.FAIL + f'\tDirectory already exists! {cli_args["dest_dir"]}/{d}' + bcolors.ENDC)

    print(bcolors.HEADER + "\nCOPYING FILES:" + bcolors.ENDC)
    for f in source_files:
        print(bcolors.OKGREEN + f'\t{cli_args["dest_dir"]}/{f}' + bcolors.ENDC)
        _ = shutil.copy(f, f'{cli_args["dest_dir"]}/{f}')


if __name__ == '__main__':
    main()
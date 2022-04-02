"""
:Name: VIU Project Deployment Script
:Contributors: Zeke Critchlow
:DateModified: 2022-02-09

:Description: This supporting script copies files from development environment
to the testing or production environment using shell SFTP commands. Shell
`stdin` will not allow passwords to be piped in, so the password has to be input
 manually, or you could set up SSH keys in advance (recommended).

NOTE: The destination path needs to be created in advance; otherwise, the script
will fail to change directory after logging in.
 """


# Standard Module Imports
import argparse
import os
import shlex
import subprocess
import sys


def parse_args() -> dict:
    """
    Collects and parses command-line arguments. Returns a dictionary of flag
    arguments as keys with their values

    :return: dictionary of arguments as keys with their associated values
    """
    # Collect arguments, create parser instance,  and parse CLI arguments
    # args = sys.argv[1:]
    parser = argparse.ArgumentParser()
    parser.add_argument("--host", default="csci.viu.ca", type=str,
                        help="Remote SFTP host name.")
    parser.add_argument("--user", default="csci375c", type=str,
                        help="Remote SFTP user account name.")
    parser.add_argument("--path", default="public_html/", type=str,
                        help="Remote SFTP destination path transfer files to")
    parser.add_argument("--source_dir", default="../public_html", type=str,
                        help="Local directory to transfer files from")

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

        for f in files:
            files_list.append(f"{root}/{f}")

    files_list = sanitize_paths(files_list)
    dirs_list = sanitize_paths(dirs_list)

    return files_list, dirs_list


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

    # Create command with arguments
    cmd_args = shlex.split(f'{cli_args["user"]}@{cli_args["host"]}:{cli_args["path"]}')
    cmd = ['sftp']
    cmd.extend(cmd_args)

    # Create sftp command subprocess
    try:
        with subprocess.Popen(cmd, stdin=subprocess.PIPE, text=True) as sftp_sub_proc:

            # Create directories in the destination directory. If they already exist
            # the `mkdir` command will fail, but should not interfere with the rest
            # of the process
            for mkdir_dir in source_dirs:
                mkdir_cmd = f'mkdir {mkdir_dir}\n'
                sftp_sub_proc.stdin.write(mkdir_cmd)

            # Put files in the destination directory. Will overwrite existing files.
            for put_file in source_files:
                put_cmd = f'put {put_file}\n'
                sftp_sub_proc.stdin.write(put_cmd)

            # Exit SFTP
            sftp_sub_proc.stdin.write('exit')

        # Exit script with OK status code
        print("Deployment complete!\n\tExiting...")
        sys.exit(os.EX_OK)

    except KeyboardInterrupt:

        print("Deployment interrupted.\n\tExiting...")
        sys.exit(os.EX_SOFTWARE)


if __name__ == '__main__':
    main()




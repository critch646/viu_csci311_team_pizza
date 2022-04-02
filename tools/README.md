# Project Tools
This document contains information about the project tools and their usage.

## deploy.py
Use Makefile command `make deploy` to execute default arguments. Creates 
directories and uploads files to target host and path. The following 
command-line arguments can be added to override their default values:
* `--host`
  * Default value `csci.viu.ca` 
  * Is the destination host name.
* `--user`
  * Default value `csci375c`
  * Is the username used to log in to remote session.
* `--path`
  * Default value `public_html/`
  * Is the remote current working directory after successful login.
  * **NOTE:** this path must be created in advance before using the script.
* `--source_dir`
  * Default value `../public_html/`
  * Is the local directory where files will be transferred from.
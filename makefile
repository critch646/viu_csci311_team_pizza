bProdDir=/home/student/stantoba/public_html/csci311/project
cProdDir=/
iProdDir=/home/student/unesikhi/public_html/csci311/project
zProdDir=/home/student/critchzc/public_html/csci311/project

dirDBInfo= ../project/php/dbinfo.inc
dirSchema= ../project/sql/users_init.sql
dirMockData= ../project/sql/MOCK_USER_DATA.sql

.phony: zcopy, dbrebuild

bcopy:
	(cd tools && python3 copy.py --dest=${bProdDir})

ccopy:
	(cd tools && python3 copy.py --dest=${cProdDir})

icopy:
	(cd tools && python3 copy.py --dest=${iProdDir})

zcopy:
	(cd tools && python3 copy.py --dest=${zProdDir})

dbrebuild:
	(cd tools && python3 db.py -a --dbinfo=${dirDBInfo} --schema=${dirSchema} --mock=${dirMockData})

dbdump:
	mysqldump --skip-lock-tables -hmarie -u csci311a -p csci311a_project > docs/db.sql.txt
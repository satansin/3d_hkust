This package connects the web interface to a database.


# Get Started

## Install MySQL

In Windows, install MySQL from https://dev.mysql.com/downloads/installer/, where the 32-bit version also works for 64-bit OS.
Select custom installation, and only keep MySQL Server and Shell for easy installation.
If MySQL server installation keeps fail, *~~smash your computer~~* try another machine.
Configure MySQL server with necessary information, and start the service.
Open MySQL Shell, and type "\sql".
\connect root@localhost:3306 to see whether the local MySQL server works.
If so, just proceed to maintain the database.

## Install Apache

Install and configure Apache following this guide https://www.znetlive.com/blog/how-to-install-apache-php-and-mysql-on-windows-10-machine/.
Apps and pages can be placed under /Apache24/htdocs/.
https://localhost/ will show some information indicating the successful Apache server start.

## Install PHP

Install and configure PHP following this guide https://www.znetlive.com/blog/how-to-install-apache-php-and-mysql-on-windows-10-machine/.
**_IMPORTANT_**: Add PHP in the **_system_** environment variable instead of the user environment variable.
Copy the folder 3DData/ to /Apache24/htdocs/.
Test if this step succeeds: http://localhost/3DData/DataUpload.php?floor=G&x=2138&y=1302.


## Create Tables and Modify Code for DB Server

Setup a new database of name "threeDData" with two tables "RawData" and "DataSet".

Change the server name, user name and password in two handler php files to match a corresponding database.


# How to Use the Interface

"RawData" stores the information of raw data first collected and "DataSet" stores the information of post-processed data.

Every stored data package has an id and three identifiers "x","y" and "floor" following the same pattern in client.

# Project for Ramverk1

This project is build in PHP with the framework [Canax](https://github.com/canax)

## Instructions for installing your own version

-   Download from Github and unzip it
-   Cd into the newly unzipped directory
-   Run `composer install` from inside the directory
-   Create the database by running `sqlite3 data/db.sqlite < sql/ddl/setup.sql` from inside the directory
-   Change permissions by running `chmod 666 data/db.sqlite` from inside the directory

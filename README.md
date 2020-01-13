[![Build Status](https://travis-ci.org/Jimpxx/ramverk1v2-project.svg?branch=master)](https://travis-ci.org/Jimpxx/ramverk1v2-project)
[![Build Status](https://scrutinizer-ci.com/g/Jimpxx/ramverk1v2-project/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Jimpxx/ramverk1v2-project/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Jimpxx/ramverk1v2-project/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Jimpxx/ramverk1v2-project/?branch=master)

# Project for Ramverk1

This project is build in PHP with the framework [Canax](https://github.com/canax)

The content you see on the website is fiction, do not take it seriously.

## Instructions for installing your own version

-   Download from Github and unzip it
-   Cd into the newly unzipped directory
-   Run `composer install` from inside the directory
-   Create the database by running `sqlite3 data/db.sqlite < sql/ddl/setup.sql` from inside the directory
-   Change permissions by running `chmod 666 data/db.sqlite` from inside the directory

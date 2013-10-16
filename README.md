Battle Plan
=========

Battle Plan is an experimental nested project management solution.

This was a quick weekend project to test an idea of a nested project manager. Turns out it works better on a mobile platform so I created tree Task:  https://github.com/gh123man/Tree-Task

Setup Guide
------------
Note: This should plug-and-play with a LAMP setup, but this hasn't been
tested yet.


Manual Setup (Ubuntu)

    apt-get install apache2
    apt-get install mysql-server
    apt-get install php5-dev #This should also pull in apache plugins as a dependency
    apt-get install php5-mysql 

    

create a database named "battlePlan" (for now) and run all queries found in utils/mysqlformat.sql on that database

GOOD TO GO!

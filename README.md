BookMe
======================

General Information
--------------------

BookMe is a CodeIgniter/Bootstrap PHP room/resource booking system aimed primarily
at educational institutes.


General Instructions
---------------------

1. Extract the archive to your web folder.

2. Create a database and username/password in MySQL for BookMe

3. Browse to http://<your_server>/BookMe/install/index.php

4. Enter the details of the MySQL database you created earlier and click install

5. Log in using bookme_admin/cr3ation to set initial settings.  Remember to turn
local logins off once LDAP is successfully working


Known Bugs
---------------------

When running through the install script, after clicking Install you may get an error
mentioning BG_COLOUR not found.  This is because the install script has forwarded on to
the actual site before the databse has been imported.  
Refreshing the page (F5) fixes this

Thanks to
---------------------

First and foremost thanks to webman and hightower/slim_jims for the amazing help
and guidance during all of this.

[CI Installer] by Mike Crittenden [http://github.com/mikecrittenden/ci-installer/]

[jQuery timepicker addon] by Trent Richardson [http://trentrichardson.com]

[jscript colour picker] by Jan Odvarko [http://odvarko.cz]
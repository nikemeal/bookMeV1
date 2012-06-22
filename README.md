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

There is an issue with the multi-booking part of BookMe and IE8.  This is due to
Microsoft enabling compatibility view on all intranet pages.
A domain wide fix can be applied (but is rather drastic), so the decision was made
to get BookMe working 100% for IE9.
IE8 will still work with 99% of BookMe, it is only the multi-booking (booking multiple
periods at once in the same week) there is an issue with.

Thanks to
---------------------

First and foremost thanks to webman and hightower/slim_jims for the amazing help
and guidance during all of this.

[CI Installer] by Mike Crittenden [http://github.com/mikecrittenden/ci-installer/]

[jQuery timepicker addon] by Trent Richardson [http://trentrichardson.com]

[jscript colour picker] by Jan Odvarko [http://odvarko.cz]
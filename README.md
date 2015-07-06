FirePages
====================
The best auto photo posting script (from folder) for facebook pages.


Usage
-----
(1) Download the contents of Zanzofily/Firepages as a zip file.

(2) Unzip the file and install composer :

![alt tag](http://im83.gulfup.com/X1xeNg.png)

(3) Edit settings in src/config.php placing your Facebook appID&Secret, your database information and your cron key.

(4) Import the SQL file placed in SQL directory to your database.

(5) Put any number of photos in the gallery directory.

(6) Control the status content from ```src/config.php ```.

(8) To save your access token to the script you have to visit connect.php and approve the requested permissions. 

(7) Using CRON JOBS in your cpanel or callmyapp.com application use this url format to activate any page in the script :

``` http://xx/cron.php?page=PAGE_ID&user=USER_ID&key=YOUR_CRON_KEY ```

Credits:
[facebook-php-sdk-v4](https://github.com/facebook/facebook-php-sdk-v4)

[joshcam MYSQLI Class](https://github.com/joshcam/PHP-MySQLi-Database-Class)
Enjoy!

# VerifyWebSite

## auth.php

### Google API
Need to use https://console.cloud.google.com/apis/ to create ClientId and ClientSecret.  
And set redirect uri to https://yourhostname/auth.php  

Set $hostname = "https://yourhostname/auth.php"  
Set ClientId  
Set ClientSecret  

## discord.php

### Discord API
Go to https://discord.com/developers/applications and create your application.  
Select your app's OAuth2 tab, and paste https://yourhostname/discord.php to Redirects.  
On SCOPE form, select identify and copy the output. Then paste it to $authorizeURL  

Set ```define('OAUTH2_CLIENT_ID', 'Your app client id');```  
Set ```define('OAUTH2_CLIENT_SECRET', 'Your app client secret');```  

## reg.php
Set these four variables to your mySQL server's setting.  
```
$servername = "mySQLServer ip";
$username = "name";
$password = "passwd";
$dbname = "db";
```

## Installation
```apt install apache2 php php-mysql php-curl```  
```curl -sS https://getcomposer.org/installer -o composer-setup.php```  
```php composer-setup.php --install-dir=/usr/local/bin --filename=composer```  
```cd /var/www/html```
```composer require google/apiclient```
```composer install```
```composer update```  
Copy ```auth.php```, ```discord.php```, ```reg.php```, and ```index.html``` to /var/www/html/  
```systemctl start apache2```

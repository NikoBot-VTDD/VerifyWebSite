# VerifyWebSite

## Setting

### web/auth.php

#### Google API
Need to use https://console.cloud.google.com/apis/ to create ClientId and ClientSecret.  
And set redirect uri to https://yourhostname/auth.php  

Set $hostname = "https://yourhostname/auth.php"  
Set ClientId  
Set ClientSecret  

### web/discord.php

#### Discord API
Go to https://discord.com/developers/applications and create your application.  
Select your app's OAuth2 tab, and paste https://yourhostname/discord.php to Redirects.  
On SCOPE form, select identify and copy the output. Then paste it to $authorizeURL  

Set ```define('OAUTH2_CLIENT_ID', 'Your app client id');```  
Set ```define('OAUTH2_CLIENT_SECRET', 'Your app client secret');```  

### web/reg.php
Set these four variables to your mySQL server's setting.  
```
$servername = "mySQLServer ip";
$username = "name";
$password = "passwd";
$dbname = "db";
```
### web/index.html
Set your domain in line 38.

### TLS/SSL(Optional)
Put your certificate in docker/tls/ca.crt  
Put your private key in docker/tls/ca.key  

If you have CACertificate, you can put it in docker/tls/CAName.crt  

Create a file in ```docker/conf/``` named ```YOUR.DOMAIN.conf```  
```YOUR.DOMAIN.conf``` content:
```
<VirtualHost *:443>
DocumentRoot "/var/www/html/"
ServerName YOUR.DOMAIN
SSLEngine on
SSLCertificateFile "/etc/apache2/ssl/ca.crt"
SSLCertificateKeyFile "/etc/apache2/ssl/ca.key"
SSLCACertificateFile "/etc/apache2/ssl/CAName.crt"
</VirtualHost>
```

## Installation
- Install docker and docker-compose
- Clone this project
- Set ```index.html```, ```auth.php```, ```discord.php```, and ```reg.php```
- ```docker-compose up```
  

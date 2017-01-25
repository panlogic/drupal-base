#Drupal Setup

1. PHP INI change - up Memory Limit to 196MB min - memory_limit = 196M

##Root SQL folder
Use for storing SQL backups for transfer between installs if required


##Root Logs folder
Optionally use for storing Apache site logs


##Root Documents folder
Use for storing site related developer documents including specs, testing, notes etc


##Sample Apache setup file
```
<VirtualHost *:80>
	ServerName drupal.local
	DocumentRoot /var/www/DRUPAL/repo/DRUPAL/webroot/
	<Directory />
		Options +FollowSymLinks
		AllowOverride All
	</Directory>
	<Directory /var/www/DRUPAL/repo/DRUPAL/webroot/>
		Options +Indexes +FollowSymLinks +MultiViews
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>

	DirectoryIndex index.php

	LogLevel warn
	ErrorLog /var/www/DRUPAL/repo/DRUPAL/logs/error.log
	CustomLog /var/www/DRUPAL/repo/DRUPAL/logs/access.log combined
</VirtualHost>
```
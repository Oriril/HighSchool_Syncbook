# Syncbook

![Syncbook Logo](http://i.imgur.com/oONGOVT.png "Syncbook Logo")

# Configuration
## .htaccess 
### https://www.syncbook.me
```apache
<VirtualHost *:80>
        ServerAdmin admin@syncbook.me
        DocumentRoot /var/www/html

        Redirect / https://syncbook.me/

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

<VirtualHost *:443>

        DocumentRoot "/var/www/html/Syncbook/src/huge/public"
        #DocumentRoot "/var/www/html/"
        ServerAdmin admin@syncbook.me

        <Directory "/var/www/html/Syncbook/src/huge/public">
                AllowOverride All
                Require all granted
        </Directory>

        SSLEngine on

        SSLCertificateKeyFile /etc/apache2/ssl/syncbook_me.key
        SSLCertificateFile /etc/apache2/ssl/syncbook_me.crt
        SSLCACertificateFile /etc/apache2/ssl/bundle.crt

</VirtualHost>
```
### https://dav.syncbook.me
```apache
<VirtualHost *:80>
        ServerAdmin admin@syncbook.me
        DocumentRoot /var/www/html/Syncbook/lib/SabreDAV
        ServerName dav.syncbook.me
        ServerAlias dav.syncbook.me


        Redirect / https://dav.syncbook.me/

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

<VirtualHost *:443>

        DocumentRoot "/var/www/html/Syncbook/lib/SabreDAV"
        ServerAdmin admin@syncbook.me
        ServerName dav.syncbook.me
        ServerAlias dav.syncbook.me


        <Directory "/var/www/html/Syncbook/lib/SabreDAV">
                AllowOverride All
                Require all granted
        </Directory>

        SSLEngine on

        SSLCertificateKeyFile /etc/apache2/ssl/syncbook_me.key
        SSLCertificateFile /etc/apache2/ssl/syncbook_me.crt
        SSLCACertificateFile /etc/apache2/ssl/bundle.crt

</VirtualHost>
```

# Syncbook

![Syncbook Logo](http://i.imgur.com/oONGOVT.png "Syncbook Logo")

# Configuration

## dnsimple Records
```
$ORIGIN syncbook.me.
$TTL 1h
syncbook.me. 3600 IN SOA ns1.dnsimple.com. admin.dnsimple.com. 1435937160 86400 7200 604800 300
syncbook.me. 3600 IN NS ns2.dnsimple.com.
syncbook.me. 3600 IN NS ns1.dnsimple.com.
syncbook.me. 3600 IN NS ns3.dnsimple.com.
syncbook.me. 3600 IN NS ns4.dnsimple.com.
www.syncbook.me. 3600 IN CNAME syncbook.me.
syncbook.me. 3600 IN MX 10 mail.syncbook.me.
syncbook.me. 3600 IN A 128.199.54.205
mail.syncbook.me. 3600 IN A 128.199.54.205
mail._domainkey.syncbook.me. 3600 IN TXT "v=DKIM1; k=rsa; t=y; "	  "p=MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApmwAeeLGARsIXlborgi+FZZhZLMkm8kXMTfGOtTedZdIfxleEu8gWBcSTw1aCbjFsZT6hl6JZFJP8cZZ7V1uO4iyIL69xa+nC7Ve6r3uGtEgjwuqDQJO25jE+vbNOYj0oOzRzERgKfj+XYvNjd41k6ciquWS6/ZX5eO53R7Ro5mfkUskLqDqx8EvxrorZGZulBZe4OLgnPW6x5ottrF10oJIpF32Q3jGR4wsyaXvnNKu1VQ27Sxy1k6vvPKuTjmd3Dzxpe1tIJagDema+1t2fBe2swVWk1hD0WP+RoolZEpT4ZbBMUiHX4KNmK+qcRJJuqag64Dml2pwT9U6dXaIMQIDAQAB"
development.syncbook.me. 3600 IN A 128.199.54.205
webmail.syncbook.me. 3600 IN CNAME syncbook.me.
_dmarc.syncbook.me. 3600 IN TXT v=DMARC1; p=quarantine; rua=mailto:admin@syncbook.me
syncbook.me. 3600 IN TXT v=spf1 mx ip4:128.199.54.205 ~all
dav.syncbook.me. 3600 IN CNAME syncbook.me.
```
![Imgur](http://i.imgur.com/702Qp44.png)
![Imgur](http://i.imgur.com/0SevKnr.png)

## namecheap
![Imgur](http://i.imgur.com/0vArduv.png)

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

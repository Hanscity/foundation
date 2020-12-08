

## apt install php

- The first time, I install php8.0, but some error occurs, it not comfitable with laravel6
- Then install php7.4, apache services start errors
- Then fixed:

> https://serverfault.com/questions/1009961/why-does-the-command-apt-install-php-try-to-install-apache/1009963#1009963

```
sudo apt install php7.4-fpm

```


- If you sudo apt install php7.4, then it will install some another modules, such as apache module;
- If you uninstall php7.4, then you will do this

```

sudo apt autoreomve php7.4
sudo apt autoremove php7.4-cli
sudo apt autoremove php7.4-fpm

sudo apt purge php7.4
sudo apt purge php7.4-cli
sudo apt purge php7.4-fpm

```

- Why ?
- because when you isstall, it have recommand you will install libapache2-mod-php7.4 | php7.4-fpm | php7.4-cgi, php7.4-common
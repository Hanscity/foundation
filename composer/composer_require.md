# Require && Update

- require 操作确实很是简单，但是选择版本却有很多的小技巧

> https://www.codementor.io/@jadjoubran/php-tutorial-getting-started-with-composer-8sbn6fb6t

## Installing packages

Visit packagist.org, Composer’s default and only repository for packages. Search for your desired package. Let’s say we want to install Facebook’s PHP sdk, we just have to search for facebook php and open the first result. That’s where we get

```
require: "facebook/php-sdk": "dev-master"

```

However dev-master usually refers to the most recent build, that’s why we need to pick the latest stable version:

```
require: "facebook/php-sdk": "3.2.3"

```


and replace it by 3.2.* in order to allow composer to update whenever there are no backward compatible updates.

Start by creating the composer.json file:


```
{
  "require": {
    	"facebook/php-sdk": "3.2.*",
    }
}


```


launch your command line in the same directory and run ``` composer install --no-dev ```

This will install the latest Facebook SDK available in 3.2.*.



## Updating packages

```
composer update --no-dev

```
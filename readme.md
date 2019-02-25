# Job application

## Requirements

Fetch and manipulate JSON data from a fictional Supermetrics Social Network REST API

Do not use any existing framework such as Laravel, Symfony, Django etc. You may use external standalone libraries if you need

Flow
1. Register a short-lived token on the fictional Supermetrics Social Network REST API

1. Fetch the posts of a fictional user on a fictional social platform and process their posts. You will have 1000 posts over a six month period. Show stats on the following:
    - Average character length / post / month
    - Longest post by character length / month
    - Total posts split by week
    - Average number of posts per user / month


Design the above to be generic, extendable and easy to maintain by other staff members.

You do not need to create any HTML pages for the display of the data. JSON output of the stats is sufficient.

## Running project

After pulling this project you should run 
```
composer install
```
Entry point (to use in Apache vhost settings) is 
> <project_dir>/public/index.php

Copy .env .ecaxample and add credentials

```
cp .env.example .env
```

## Testing project

Tests can be run by:

```
vendor/bin/phpunit
```

Tests can be found in:
> <project_dir>/tests

## Contacts
If you like what you see, you can contact me through my [LinkedIn](https://www.linkedin.com/in/gediminas-radzevičius-51a04494).
I'm always open to new opportunities. 


## Main points to have in mind when working  with this project

### Routing

For routing I used something from my other project (writen by me) with minimal modification.
Routes can be found in:
> <project_dir>/config/routes.php

Route naming convention is as in laravel:
>\<metthodName>@\<controllerName>

### Dependency injection

For  dependency injection container I used [symfony/dependency-injection](https://symfony.com/doc/current/components/dependency_injection.html).
 It lets easily interchange implemantations.
 Classes, Interfaces and which class is used for which interface implementation is registered in :
 > <project_dir>/bootstrap/mapForDependencyContainer.php
 
### Project structure

config - main structure/settings for project   
public - dir to which server should point  
src - main code base   
tests -  phpunit tests

### used dependencies
* [symfony/dependency-injection](https://symfony.com/doc/current/components/dependency_injection.html) - for dependency injectioncontainer and autowiring
* [guzzlehttp/guzzle](https://github.com/guzzle/guzzle) - for making request toa api
* [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) - for reading .env file, and setting environment variables
* [nesbot/carbon](https://github.com/briannesbitt/Carbon) - to make working withdates easier
* [phpunit/phpunit](https://phpunit.de/index.html) - for testing
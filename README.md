# PHPStan and Rector custom rules tutorial

This repository contains the code to support PHPStan and Rector custom rules tutorial.


## Pre tutorial setup

1. Set up an environment with either PHP 8.3, 8.4 or 8.5. (Or you can use docker, see below)
1. Clone this repository.
1. Run: `composer install`
1. Run all the checks. There is a composer script for this: `composer run-script all-checks`

You should see something similar to this:

```
./composer.json is valid
Note: Using configuration file /app/phpstan.neon.
 7/7 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%


                                                                                                                        
 [OK] No errors                                                                                                         
                                                                                                                        

PHPUnit 12.4.3 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.4.14
Configuration: /app/phpunit.xml

.                                                                   1 / 1 (100%)

Time: 00:00.001, Memory: 20.00 MB

OK (1 test, 1 assertion)
```

Providing you don't get any errors, you're all good to go!


## Docker images

There are docker files that have been tested on docker for [MacOS](https://docs.docker.com/desktop/install/mac-install/).

### Build the container

```shell
docker compose build
```

### Run docker commands

```shell
docker compose run --rm <php83|php84|php85> <command>
```

E.g.

```shell
# Composer install
docker compose run --rm php84 composer install

# Run all CI checks
docker compose run --rm php84 composer all-checks

# Run the tests
docker compose run --rm php84 vendor/bin/phpunit

# Run PHPStan
docker compose run --rm php84 vendor/bin/phpstan

# Run rector
docker compose run --rm php84 vendor/bin/rector
```

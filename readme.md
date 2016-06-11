# Zikkio PHP Starter (Laravel)

Zikkio PHP Starter is the codebase that aims to uniform as much as possible the various applications composing the Zikkio Ecosystem. 

## Differences from Laravel
It diverges from default Laravel in a few things:
 - All unnecessary boilerplate has been replaced with new, shiny, unnecessary boilerplate 
 - Two classes extending `Illuminate\Database\Eloquent\Model` to use as base class for all models, one for SQL-based models and one for NoSQL (only DynamoDB)
 - A **JWT** library is provided ([`firebase/php-jwt`](https://github.com/firebase/php-jwt))
 - A JWT-based `Guard` implementation is provided (will be replaced by `tymon/jwt-auth` when it gets to 1.0)
 - A library for **CORS** handling is provided ([`barryvdh/laravel-cors`](https://github.com/barryvdh/laravel-cors))
 - **AWS** connection is provided through the official sdk ([`aws/aws-sdk-php-laravel`](https://github.com/aws/aws-sdk-php-laravel))
 - A library for **UUID** generation is provided ([`ramsey/uuid`](https://github.com/ramsey/uuid))
 - Both **PHPUnit** and **PHPSpec** are provided with the respective configuration files

## Installation
A new project using this starter package can be created with the following command
```
composer create-project --prefer-dist zikkio/laravel-starter service 
```

## Setup
The first step to a proper initialization is to generate both the laravel and jwt-auth keys
###### Laravel key
```bash
php artisan key:generate
```
###### .env population
As with Laravel, you'll have to rename the `.env.example` file and fill values where needed (Ex. generate `JWT_SECRET`, `ZIKKIO_NODE_SECRET`, etc.)

Next, the `composer.json` should be updated with the proper information
```
"name": "zikkio/service-<service-name>",
"description": "<service-description>",
"authors": {
    {}, ...
    <service-author>
}
```

## Init
This project comes with a `docker-compose.yml.example` orchestrating 6 images:
 - a basic PHP7 (FPM) image (`zikkio/base-php`)
 - a basic NGINX image (`zikkio/base-nginx`)
 - two images to run (respectively) **composer** and **artisan** commands (`zikkio/base-composer` and `zikkio/base-artisan`)
 - the official **MariaDB** image (if needed)
 - the official **Redis** image (if needed)
 
Local development configuration is, of course, up to the developer. The `docker-compose.yml` is git-ignored to allow developers to setup their environement freely.
One can even choose to not use Docker at all, **Homestead** or **Valet** are reasonable choices 
**but** the developer should keep in mind that _the application will be deployed in a Docker-based environement_, so it **has to** stay compatible with docker 
 
## Known issues
The following are known issues in the TODO list
###### File permissions
 - Right now, `src/storage` folder needs a `chmod -R 777` for the app to write logs and cache files. 



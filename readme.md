# Poultry Farm Manager

This is a web based poultry farm management developed using the laravel framework.

## Requirement :

PHP 7

composer

npm

mysql database

## Set Up

#### Install composer dependencies

composer install

### Install npm dependencies

npm install

### Configure environment viarable

create a copy of .env.exampl and rename to .env
or
run php -r "file_exists('.env') || copy('.env.example', '.env')

### Database setup

Create an empty database for the application.

In the .env file fill in the DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD options to match the credentials of the database you just created.

### Create database tables

run php artisan migrate

### Generate an app encryption key

php artisan key:generate

### Seed database [Optional]

To populate the database with test data, seed the database

run php artisan db:seed

Use the credentials to access the test account

_email: testaccount@mail
password: password_

### run

php artisan serve

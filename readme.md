# Poultry Farm Manager

This is a web based poultry farm management developed using the laravel framework.
The code has been modified to be integrated with php desktop and used as an offline desktop application using sqlite.

## Requirement :

PHP >=7.3

composer

npm

## Set Up

#### Install composer dependencies

composer install

### Install npm dependencies

npm install

### Configure environment viarable

create a copy of .env.example and rename to .env
or
run php -r "file_exists('.env') || copy('.env.example', '.env')

### Database setup

Create an empty sqlite file name database.sqlite in the database/ directory

In the .env delete the DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD options and change the DB_CONNECTION option to sqlite.

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

### Integration with phpdesktop

visit [phpdesktop project](https://github.com/cztomczak/phpdesktop) for instructions

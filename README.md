# Evertec Test

Laravel E-commerce with the PlacetoPay integration.

## Demo

[https://store-pwa.herokuapp.com](https://store-pwa.herokuapp.com)


## Requirements

```
PHP >= 7.2.5
Composer
Git SCM
SOAP PHP Extension
BCMath PHP Extension
Ctype PHP Extension
Fileinfo PHP extension
JSON PHP Extension
Mbstring PHP Extension
OpenSSL PHP Extension
PDO PHP Extension
Tokenizer PHP Extension
XML PHP Extension
```

## Installation

Clone the repository.

```
git clone https://github.com/jabg97/store.git
```

Go into the project folder and type the following command.

```
composer install
cp .env.local .env
```
if you are using Windows CMD, you must use "copy" command insteand "cp" command
```
copy .env.local .env
```
Configure .env file with your database credentials and then type the following command to execute migrations and seeders.

*NOTE: be careful, this will drop all the tables in the database*
```
php artisan migrate:fresh --seed
```
## Run server

```
php artisan serve
```
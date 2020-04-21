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

## Sync information

For sync pending orders you must configure a cronjob in your server and execute the following artisan command every minute.

```
php artisan p2p:sync
```
or you can make a request to the following route

```
YOUR_SERVER_BASE_URL/api/p2p/sync 
```
For example:
http://127.0.0.1/api/p2p/sync

if you can't configure a cron job in your server, you can use services like 
[https://cron-job.org](https://cron-job.org)

if you can't do any of these options, there is a javascript simulation into "app.blade.php" file, which send an ajax request every 60 seconds.

*NOTE: you should consider, this only will work, when you are in the website, it doesn't work like a background task*
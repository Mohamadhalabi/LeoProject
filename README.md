
## Dasbhoard Laravel 9.0 

## requirements
**1-php 8.0**

**2-mysql**

## Installation
### 1- open the cmd and run composer 

`composer install `

### 2-create database at mysql 

if you use default setting please logging to : http://localhost/phpmyadmin

and create new databasel 

### 3- go to .env 

set configuration database  
 
### 4-open the cmd and run

``php artisn migrate --seed``

``php artisan migrate (after changing the database name in env)``
``php artisan db:seed ``
``php artisan db:seed --class=SettingSeed``
``php artisan db:seed --class=AdminUser``
``php artisan db:seed --class=LanguageSeed``

### 5-open the cmd and run

``php artion serve --port=8000``

go to browser and open the http://localhost:8000

if you want access to admin 

go to  http://localhost:8000/admin


**username is : admin@esg.com**

**password is : password**

go to  http://localhost:8000/

 

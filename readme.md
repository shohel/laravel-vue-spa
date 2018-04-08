## A Sample project to learn how to work VueJS SPA with Laravel

I've trying to cover all features available in VueJS, this project is fully ready and you've to nothing extra to run it. Just clone this project, connect with database, import database from sql-backup located at root. In this project, vue will get your API url automatically from Laravel Route. All of Laravel routes you can access dynamically at VueJS with same name you give at laravel route.

See the live example at project

## How to run (Install)

1. Clone the project to your local server or your remote server

```
git clone git@github.com:mh-shohel/laravel-vue-spa.git
cd laravel-vue-spa
sudo cp .env.example .env
php artisan key:generate
```
2. Create database to MySQL and import
  
```
A Ready database I've proivded, you will found it root/sql-backup directory import
```
3. Place your database information at .env file located at root directory
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vue_blog
DB_USERNAME=root
DB_PASSWORD=root

```

Congratulation, you are set, now browse your application using browser address

VueJS source?
```
VueJS source is located at root/public/assets/vue-js
VueJS build you will found at root/public/assets/js/vue.js
```
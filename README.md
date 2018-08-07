# Laravel-Vue SPA 

<a href="https://travis-ci.org/cretueusebiu/laravel-vue-spa"><img src="https://travis-ci.org/cretueusebiu/laravel-vue-spa.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/cretueusebiu/laravel-vue-spa"><img src="https://poser.pugx.org/cretueusebiu/laravel-vue-spa/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/cretueusebiu/laravel-vue-spa"><img src="https://poser.pugx.org/cretueusebiu/laravel-vue-spa/v/stable.svg" alt="Latest Stable Version"></a>

> A Laravel-Vue SPA starter project template.

<p align="center">
<img src="https://i.imgur.com/NHFTsGt.png">
</p>

## Features

- Laravel 5.6 
- Vue + VueRouter + Vuex + VueI18n + ESlint
- Pages with dynamic import and custom layouts
- Login, register and password reset
- Authentication with JWT
- Socialite integration
- Bootstrap 4 + Font Awesome 5

## Installation
Configure MySQL following tutorial.

Settings
```bash
# Create .env file
cp .env.example .env
```
Change in the `.env` file fields:

`DB_DATABASE=dbname`

`DB_USERNAME=dbuser`

`DB_PASSWORD=userpassword`

PHP part
```bash
# install php dependencies
composer install

# Additional commands
php artisan key:generate
php artisan jwt:secret

#migrate database
php artisan migrate
php artisan db:seed
```
JavaScript part
```bash
# install javascript dependencies
npm install

# build application
npm run dev
```
## Usage
```bash
# start dev server on 8888 port
php artisan serve --port="8888"
```

## Usage - For a manually configured apache server

#### Development

```bash
# build and watch
npm run watch

# serve with hot reloading
npm run hot
```

#### Production

```bash
npm run production
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

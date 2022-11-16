# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/lumen)](https://packagist.org/packages/laravel/lumen-framework)


## Installation

1. Clone repository
2. run ``cp .env.example .env``
3. edit database credentials in ``.env file``
2. run ``composer install``
3. run ``php artisan key:generate``
3. run ``php artisan migrate --seed``
3. run ``php -S localhost:8000 -t public``

## API LIST
``base url: http://127.0.0.1:8000/api/user``

```
/ [GET]
/register [POST]
/sign-in [POST]
/recover-password [POST]
/recover-password [PATCH]
/companies [POST]
/companies [GET]

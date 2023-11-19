<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Commander

Commander Helps developers to generate nextjs code to increase the development process faster.

It is only for developers to use

- [How to Install Commander](https://laravel.com/docs/routing).
- [Explore the Commander Commands](https://laravel.com/docs/container).
- [Contributors](https://laravel.com/docs/queues).


## Installing Commander

- Clone this repository
```shell
git clone https://github.com/saifur-rahman-hasan/commander.git commander
```

- Make sure you have installed php and composer based on your OS
- Install the composer.json
```shell
composer install
```

## Commander Commands

#### Make Service
```shell
php artisan commander:make-service
```

or 

```shell
php artisan commander:make-service MyService
```


#### Make Controller
```shell
php artisan commander:make-controller
```
```shell
php artisan commander:make-controller MyController --service-MyService
```



#### Make Action
```shell
php artisan commander:make-action
```
```shell
php artisan commander:make-action MyAction --service-MyService
```

#### Make Repository
```shell
php artisan commander:make-repository
```
```shell
php artisan commander:make-repository MyRepository --service-MyService
```

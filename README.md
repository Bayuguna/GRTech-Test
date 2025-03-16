<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Project

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

Install Project

```js
  //Install the dependecy module
  composer install
```

Add and Edit .env file.

```js
    //Edit this database connection
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=grtech
    DB_USERNAME=root
    DB_PASSWORD=

    //Edit this mailer settings
    MAIL_MAILER=smtp
    MAIL_SCHEME=null
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=example@gmail.com //change this with your email
    MAIL_PASSWORD='<GENETATE_APP_KEY>' //change this with generate app passwords
    MAIL_FROM_ADDRESS="example@gmail.com" //change this from who the email came
    MAIL_FROM_NAME="${APP_NAME}"
    MAIL_TO_ADDRESS="example@gmail.com" //change this to where email be sent
    MAIL_TO_NAME="${APP_NAME}"
```

Generate app password: [Google App Password](https://myaccount.google.com/apppasswords)

```js
  //Generate the key
  php artisan key:generate
```

```js
  //Generate database table with migration && Run DB Seeder
  php artisan db:refresh-seed --fresh

```

Run the project

```js
  //It will running vite and php server
  npm run start
```

Default username and password

```js
  //Admin
    username: admin@grtech.com
    password: password

  //User
    username: user@grtech.com
    password: password
```

## Build With

Laravel, Vue, Ant Design

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

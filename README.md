<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

# Akosmd
Akosmd Test Project CRUD for Login and Product.
### Technologies Used
This App uses a number of open source projects to work properly:
* [PHP][7.4.*] - PHP Language For Backend
* [Laravel][8.6.*] - Rich Functional PHP Based Web Framework
### Installation
Please Follow These Steps to Setup & Run The Application:
1. Clone The Code.
2. Go to Project Root Directory.
3. Create New ```.env``` File By Copy ```.env.example``` File. Chnage The Database Name and Credentials.
4. Create A Database With The Same Name Which Is Define In ```.env``` File.
5. Then Run The Following Commands.
```sh
$ composer install
$ php artisan passport:install
$ php artisan migrate:fresh
$ php artisan db:seed
$ php artisan serve
```
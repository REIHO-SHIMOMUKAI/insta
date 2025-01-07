# How to start this project
1. Open XAMPP.
2. Click the "Start" buttons for both "Apache" and "MySQL" modules.
3. Setup the Project (First-time setup only)  
If you are running this project for the first time, follow these steps:
- Open a terminal or command prompt.
- Navigate to the project directory:
```
cd C:\xampp\htdocs\dev3-laravel\laravel-insta
```
- Install dependencies:
```
composer install
```
- Copy the .env file:
```
copy .env.example .env
```
- Generate the application key:
```
php artisan key:generate
```
- Configure the .env file (Database settings):
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=insta
DB_USERNAME=root
DB_PASSWORD=
```
Run database migrations:
```
php artisan migrate
```
4. Open the following URL in your browser (e.g., Chrome):
```
http://localhost/dev3-laravel/laravel-insta/public/
```

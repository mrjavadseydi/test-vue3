# setup

### option 1 : use the docker-compose file to run the project
```bash
cd docker
docker-compose build
docker-compose up -d
docker-compose exec app composer install
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan test
docker-compose exec app npm install
docker-compose exec app npm run dev
docker-compose exec app npm run build
```
now you can access the project on http://localhost:8011

the admin default credentials are:

email :admin@admin.com 

password : 123

if you failed to login with the default credentials try again running the seed command

### option 2 : use the local environment
environment requirements:
- php 8
- composer
- npm
- mysql

step 1 :
copy the .env.example file to .env

step 2 : 
create a new database and update the .env file with the database credentials

step 2 : 
run the following commands
```bash
composer install
php artisan key:generate
npm install
npm run dev # you may need to stop the process after the first build 
npm run build
php artisan migrate
php artisan db:seed
php artisan test
php artisan serve
```
now you can access the project on http://localhost:8000

----
### time on the project
total : 13 hours

---

## todo :

## Project Structure
- [x] Structure the project to be compatible with Laravel Modules. Reference: [nWidart/laravel-modules](https://github.com/nWidart/laravel-modules)


### Users Module
- [x] Implement Create, Delete, Edit, and List functionality for users management.
- [x] Database fields for the users table:
    - [x] Name
    - [x] Last Name
    - [X] Mobile Number
    - [x] Email
    - [x] Password
    - [x] Role (Use Enum with values: Customer, Operator, Admin)

### Settings Module
- [x] Provide the ability for admins only to clear cache files and routes cache.

## General Requirements

- [x] Separate the frontend similar to the backend for each module.
- [x] Use Sanctum for authentication. Ensure that the login and register functionalities are outside the modules scope.
- [x] Utilize Vite for front-end tooling.
- [x] Ensure the project includes tests.
- [x] Preferably include Docker setup.
- [x] Host the project on GitHub.
- [x] Document the setup process of the project.
- [x] In the documentation, include the time spent on each section of the project.

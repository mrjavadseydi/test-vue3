# todo :

## Project Structure
- [x] Structure the project to be compatible with Laravel Modules. Reference: [nWidart/laravel-modules](https://github.com/nWidart/laravel-modules)

## Modules

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

- [ ] Separate the frontend similar to the backend for each module.
- [ ] Use Sanctum for authentication. Ensure that the login and register functionalities are outside the modules scope.
- [ ] Utilize Vite for front-end tooling.
- [ ] Ensure the project includes tests.
- [ ] Preferably include Docker setup.
- [x] Host the project on GitHub.
- [ ] Document the setup process of the project.
- [ ] In the documentation, include the time spent on each section of the project.


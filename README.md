# todo :

## Project Structure
- [ ] Structure the project to be compatible with Laravel Modules. Reference: [nWidart/laravel-modules](https://github.com/nWidart/laravel-modules)

## Modules

### Users Module
- [ ] Implement Create, Delete, Edit, and List functionality for users management.
- [ ] Database fields for the users table:
    - [ ] Name
    - [ ] Last Name
    - [ ] Mobile Number
    - [ ] Email
    - [ ] Password
    - [ ] Role (Use Enum with values: Customer, Operator, Admin)

### Settings Module
- [ ] Provide the ability for admins only to clear cache files and routes cache.

## General Requirements

- [ ] Separate the frontend similar to the backend for each module.
- [ ] Use Sanctum for authentication. Ensure that the login and register functionalities are outside the modules scope.
- [ ] Utilize Vite for front-end tooling.
- [ ] Ensure the project includes tests.
- [ ] Preferably include Docker setup.
- [ ] Host the project on GitHub.
- [ ] Document the setup process of the project.
- [ ] In the documentation, include the time spent on each section of the project.


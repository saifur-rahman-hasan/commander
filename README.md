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

- [How to Install Commander](https://github.com/saifur-rahman-hasan/commander#installing-commander).
- [Explore the Commander Commands](https://github.com/saifur-rahman-hasan/commander#commander-commands).
- [Understand the Architecture](https://github.com/saifur-rahman-hasan/commander#Architecture).
- [Contributors](https://github.com/saifur-rahman-hasan/commander#contributors).


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

## Configure Commander Input & Output
Configure your Commander input, output and stub files path if needed.

```php
// config/commander.php

<?php

$commanderInputPath = "CommanderInput";
$commanderOutputPath = "CommanderOutput";
$commanderInputStbFilesPath = "CommanderInput/stubFiles";

return [
    'stub_files_path' => base_path($commanderInputStbFilesPath),
    'commander_input_path' => base_path($commanderInputPath),
    'commander_output_path' => base_path($commanderOutputPath),
    'core_path' => base_path("$commanderInputStbFilesPath/core"),
    'service_path' => base_path("$commanderOutputPath/services"),
    'app_path' => base_path("$commanderOutputPath/app"),
    'api_path' => base_path("$commanderInputStbFilesPath/app/api"),
    'api_input_path' => base_path("$commanderInputStbFilesPath/app/api"),
    'api_output_path' => base_path("$commanderOutputPath/app/api")
];

```


## Commander Commands

#### Commander Init
```shell
php artisan commander:init
```

#### Make Service
```shell
php artisan commander:make-service
```

#### Make Controller
```shell
php artisan commander:make-controller
```

#### Make CRUD Controller
```shell
php artisan commander:make-curd-controller
```

#### Make Action
```shell
php artisan commander:make-action
```

#### Make Repository
```shell
php artisan commander:make-repository
```

#### Make Interface
```shell
php artisan commander:make-interface
```

#### Make Api Route
```shell
php artisan commander:make-api-route
```

## Architecture

### Directory Structure of a Service
```
service/
|-- controllers/
|   |-- UserController.ts
|   |-- AuthController.ts
|   |-- AdminUserController.ts
|-- models/
|   |-- User.ts
|   |-- Role.ts
|   |-- Permission.ts
|   |-- UserAccessControl.ts
|-- interfaces/
|   |-- DefaultInterfaces.d.ts
|   |-- UserInterfaces.d.ts
|   |-- AuthorizationInterfaces.d.ts
|-- repositories/
|   |-- UserRepository.ts
|   |-- AdminUserRepository.ts
|   |-- RoleRepository.ts
|   |-- PermissionRepository.ts
|   |-- UserAccessControlRepository.ts
|   |-- ...
|-- actions/
|   |-- UserCreateAction.ts
|   |-- UserUpdateAction.ts
|   |-- UserDeleteAction.ts
|-- views/
|   |-- pages/
|   |   |-- LoginPage.tsx
|   |   |-- RegisterPage.tsx
|   |   |-- ProfilePage.tsx
|   |   |-- PasswordResetPage.tsx
|   |   |-- PasswordRecoverPage.tsx
|   |   |-- ...
|   |-- components/
|   |   |-- FormUserCreate.tsx
|   |   |-- FormUserUpdate.tsx
|   |   |-- FormUserDelete.tsx
|   |   |-- DataTableUserList.ts
|   |   |-- DataTableRoleList.ts
|   |   |-- DataTablePermissionList.ts
|   |   |-- DropdownUserList.ts
|   |   |-- DropdownRoleList.ts
|   |   |-- DropdownPermissionList.ts
|   |   |-- ...
|   |-- layouts/
|   |   |-- layout.tsx
|   |   |-- template.tsx
|   |   |-- ...
|   |-- interfaces/
|   |   |-- DefaultInterfaces.d.ts
|-- middleware/
|   |-- middleware.ts
|-- hooks/
|   |-- useAuth.ts
|   |-- useAuthorize.ts
|-- redux-store/
|   |-- UserApiSlice.ts
|   |-- UserSlice.ts
```

#### Service 
A service is a modular software component that encapsulates business logic, data handling, and user interface interactions. Comprising controllers for input handling, models for data representation, interfaces for contract definitions, repositories for data access, views for user presentation, middleware for request processing, and hooks for functionality extension, this organized structure enhances code maintainability and enforces the separation of concerns in development.

#### Controller
Controllers are responsible for managing input within a service, orchestrating the flow of data and interactions. They handle user requests, delegate tasks to models and services, and facilitate communication between the user interface and underlying business logic, contributing to a well-organized and structured software architecture.

#### Repository
Repositories manage data access within a service, acting as an intermediary between the application and the data source. They encapsulate database interactions, abstracting away the underlying storage details. Repositories promote code maintainability by centralizing data-related operations and facilitating a consistent interface for data retrieval and manipulation.

#### Model
Models represent the data and business logic within a service. They define the structure of data entities, encapsulate validation rules, and handle interactions with the underlying database through repositories. Models contribute to a modular and organized codebase, ensuring a clear separation between data representation and application logic.

#### Interface
Interfaces define contracts within a service, specifying the methods and properties that must be implemented by classes. They establish a set of rules for interactions between different components, promoting code consistency and allowing for the creation of interchangeable implementations. Interfaces enhance modularity and enable a more flexible and extensible software architecture.

#### Views
Views are responsible for presenting data to the user within a service. They represent the user interface components, rendering information from models and facilitating user interactions. Views contribute to the overall organization by separating the presentation layer from the underlying business logic, promoting code clarity and maintainability.

#### Action
Actions in a service define discrete units of work triggered by events or user interactions. They encapsulate the logic associated with these events, serving as a bridge between user interactions, controllers, and the underlying business logic. Actions contribute to a modular and scalable architecture, facilitating the organization of application behavior.

#### Redux Store
The store in a service acts as a centralized data repository, managing the application's state. It stores and retrieves data that components across the service can access and modify. The store is a key component in state management, enhancing predictability and maintainability in applications with complex data flows.

#### Hooks
Hooks provide a way to extend or modify the behavior of a service by injecting custom functionality at specific points in the application lifecycle. They act as entry points for developers to add their code and customize the service's behavior, promoting flexibility and enabling the creation of reusable and shareable code snippets.

#### Middleware
Middleware in a service intercepts and processes requests or events before they reach the core business logic. It enables the implementation of cross-cutting concerns such as logging, authentication, or data transformation. Middleware promotes modular and reusable code by separating these concerns from the main application logic.

#### Provider
Providers are components that supply or manage resources, services, or dependencies across the application. They act as a centralized source for accessing and configuring various services, fostering a clean and organized way to manage dependencies and promote a consistent interface for resource consumption throughout the application.


### Docker
```shell
composer require laravel/sail --dev
```

```shell
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

```shell
php artisan sail:install
```


```shell
sail up
sail up -d
sail stop
```

```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```


## Contributors
Thanks go to these wonderful people ([Commander](https://github.com/saifur-rahman-hasan/commander)):

<table>
  <tbody>
    <tr>
      <td align="center" valign="top" width="14.28%"><a href="https://github.com/saifur-rahman-hasan"><img src="https://avatars.githubusercontent.com/u/13752895?s=400&u=42df84b1c3433ab5d406c59c6a5c262d87f116be&v=4" width="100px;" alt="Saifur Rahman"/><br /><sub><b>Saifur Rahman</b></sub></a><br /><a href="#question-kentcdodds" title="Answering Questions">💬</a> <a href="https://github.com/all-contributors/all-contributors/commits?author=kentcdodds" title="Documentation">📖</a> <a href="https://github.com/all-contributors/all-contributors/pulls?q=is%3Apr+reviewed-by%3Akentcdodds" title="Reviewed Pull Requests">👀</a> <a href="#talk-kentcdodds" title="Talks">📢</a></td>
    </tr>
  </tbody>
</table>

# jumia

A sample application to list phone numbers from multiples countries and allow to filter the numbers by country and by number's state (valid or invalid)

## Prerequisites

- PHP 7.1 or greater
- Composer
- PDO SQLite extension

## Building the application

```
composer install
```

## Running tests and coverage report

To run tests:
```
composer test
```

To generate code coverage report:
```
composer coverage-report
```

## Starting the application

To start the application using the PHP built-in server (by default it's running in localhost:8000):
```
composer run
```

To start the application using an apache/nginx server create a virtual host pointing to the project root.


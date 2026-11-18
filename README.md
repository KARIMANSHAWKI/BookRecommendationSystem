
## Intro

This project about book recommendation system.


## Installation and usage instructions

1- Setup Environment:


I use docker compose to setup environemnt then you need to run these 

```bash
docker-compose up -d --build
```
to access php container

```bash
docker exec -it container_name bash
```

2- Composer install:


inside php conatiner run :

```bash
composer install
```

2- Migrate Database:

```bash
php artisan migrate --seed
```

## Postman Collection

You Can Access api using postman through this postman collection :
https://documenter.getpostman.com/view/15241626/2sA3JJ8hfm





## Secure book listing API

`GET /api/v1/books?search=Laravel&per_page=10&page=1`

Send `Accept: application/json` and `Authorization: Bearer <token>`.
The endpoint requires Sanctum authentication and the `view books` permission.
For an existing installation, run `php artisan db:seed --class=RolesAndPermissionsSeeder` to configure the permission and roles.

- Optional search matches book names or descriptions (maximum 100 characters).
- Page size defaults to 15 and is limited to 1–100; page is limited to 1–10000.
- Eloquent binds search values, eager loads sections, and orders by ID before pagination.
- BookResource returns an allowlisted representation with pagination links and metadata.
- JSON requests return 401 for missing authentication, 403 for missing permission, and 422 for invalid parameters.

Run the feature tests from the Laravel app directory with a configured test database:

```bash
php artisan test --filter=BookListingTest
```

The existing single-book endpoint remains public as part of the original catalog design. If the catalog itself must be private, apply equivalent authorization to all book read endpoints.

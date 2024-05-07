
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

You Can Access api using postman through this postman collection :
https://documenter.getpostman.com/view/15241626/2sA3JJ8hfm





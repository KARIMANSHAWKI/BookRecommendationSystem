
## Intro

This project about book recommendation system.


## Installation and usage instructions

1- Setup Environment:

```bash
I use docker compose to setup environemnt then you need to run these 
```
```bash
docker-compose up -d --build
```
```bash
to access php container

docker exec -it container_name bash
```

2- Composer install:

```bash
inside php conatiner run :

composer install
```

2- Migrate Database:

```bash
php artisan migrate --seed
```

```bash
You Can Access api using postman through this postman collection :
https://documenter.getpostman.com/view/15241626/2sA3JJ8hfm
```





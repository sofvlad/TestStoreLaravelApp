# Test Store Laravel App

A store with catalog and filters implemented by the Laravel Framework

## Clone repo
```
git clone https://github.com/sofvlad/TestStoreLaravelApp
```

## Docker Deploy
> [!NOTE]
> For local deploy you need add `127.0.0.1 store.local` into hosts file
```
cp .env.example .env
docker-compose build
docker-compose up
docker exec -it php /bin/sh
php artisan migrate
php artisan db:seed
```

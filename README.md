# Cronus

Cronus is a simple CRM solution for freelancers and small business owners.

This project was made based in Flow CRM.

## Requisites

- Node version v16.20.2

## Quick setup

1. Install docker and docker-compose
    - [Docker Install documentation](https://docs.docker.com/install/)
    - [Docker-Compose Install documentation](https://docs.docker.com/compose/install/)
2. Run command `docker-compose up -d` for create the containers
3. Run command `cp .env.example .env` for create env file
4. Run command `docker exec -i app composer install` for install composer dependencies
5. Run command `docker exec -i app php artisan key:generate` for generate the secret
6. Run command `docker exec -i app php artisan migrate` for create tables in database
7. Run command `npm install` for install node dependencies
8. Run command `npm run prod|dev` for generate files

Optionally you can run

- `docker ps -a` for see the containers running
- `docker exec app php artisan queue:work --tries=3` for run the queue and send emails

After these steps you can access the project on [localhost](http://localhost)

## Screens from project

Some images from project. For see all the screens, checkout and run it locally.

### Login
![login.png](_readme_images%2Flogin.png)

### Register
![register.png](_readme_images%2Fregister.png)

### Overview
![overview.png](_readme_images%2Foverview.png)
---
![overview-black.png](_readme_images%2Foverview-black.png)

### Leads
![leads.png](_readme_images%2Fleads.png)

### Settings
![settings.png](_readme_images%2Fsettings.png)

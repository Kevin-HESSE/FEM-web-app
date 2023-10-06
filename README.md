# Entertainment web app

## Objectives

The main objective of this application is to reproduce the design from this [challenge](https://www.frontendmentor.io/challenges/entertainment-web-app-J-UhgAW1X) with a responsive design. I work on a fullstack project with the technologies mentionned in the following section.

## Technologies used 

Frontend : 

![image](https://img.shields.io/badge/Twig-BACF29?style=for-the-badge&logo=Twig&logoColor=white)
![image](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D)
![image](https://img.shields.io/badge/Sass-CC6699?style=for-the-badge&logo=sass&logoColor=white)
![image](https://img.shields.io/badge/Webpack-8DD6F9?style=for-the-badge&logo=Webpack&logoColor=white)
![image](https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E)

Backend :

![image](https://img.shields.io/badge/Symfony-000000?style=for-the-badge&logo=Symfony&logoColor=white)
![image](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)
![image](https://img.shields.io/badge/Docker-2CA5E0?style=for-the-badge&logo=docker&logoColor=white)

## Demo

A demo of the site is available [here](https://entertainment-web-app-7d194b4f2ebb.herokuapp.com/)

You need an account to play with :
- User : `test@entertainment.io` or `admin@entertainment.io`
- Password : `archive` (same password for each)

The user creation and reset password are disabled.

## How to install

### Requirement 

You need to have Docker and Make install.

### Set up

You need to create .env.local file and configuring the `PG_USER`, `PG_PASSWORD`, `PG_DATABASE` and `DATABASE_URL` variable.

Then run : 
```bash
make install
```

This command will :
1. build image
2. start the container 
3. installing dependencies for Symfony and Webpack Encore
4. create table and inject data inside the database

### No docker setup

You need to install the different packages :
- Php 8.1 with the intl module 
- Symfony CLI
- Node 18 with yarn
- PostgreSQL 13

and run the following commands instead :

```bash
composer install
yarn install
php bin/console doctrine:migrations:migrate
psql -U USERNAME -d DATABASE < data/seed.sql
php bin/console cache:clear
```
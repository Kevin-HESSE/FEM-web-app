.PHONY: build clear migrations migrate seed entity up stop dev_deploy cache_clear node_init

up:
	docker-compose --env-file ./.env.local up -d

stop:
	docker-compose stop

build:
	docker-compose build

dev_deploy: clear up migrate seed cache_clear

clear: # Delete all container and volumes generated
	docker-compose rm -f
	docker volume rm fem-wep-app_pg_data

vendor: composer.lock
	docker-compose exec symfony composer install

node_modules: package.json
	docker-compose exec node yarn install

migrations: #Generate a new migration
	docker-compose exec symfony php bin/console make:migration

migrate: #Push the migrations to the database
	docker-compose exec symfony php bin/console doctrine:migrations:migrate

seed:
	docker-compose exec -T database psql -U toto -d wep_app < data/seed.sql

entity:
	docker-compose exec symfony php bin/console make:entity

cache_clear:
	docker-compose exec symfony php bin/console cache:clear

node_init: build
	docker-compose run --rm -v $(pwd):/home/node/app node yarn install

first_install: node_init dev_deploy vendor cache_clear

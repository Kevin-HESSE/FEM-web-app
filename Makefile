ifneq (,$(wildcard ./.env.local))
    include .env.local
    export
endif

.PHONY: build clear migrations migrate seed entity up stop dev_deploy cache_clear install

up:
	docker-compose --env-file ./.env.local up -d

stop:
	docker-compose stop

build:
	docker-compose --env-file ./.env.local build

dev_deploy: clear up migrate seed cache_clear

clear: # Delete all container and volumes generated
	docker-compose rm -f
	docker volume rm fem-wep-app_pg_data

vendor: composer.lock
	docker-compose exec symfony composer install

migrations: #Generate a new migration
	docker-compose exec symfony php bin/console make:migration

migrate: #Push the migrations to the database
	docker-compose exec symfony php bin/console doctrine:migrations:migrate

seed:
	docker-compose exec -T database psql -U ${PG_USER} -d ${PG_DATABASE} < data/seed.sql

entity:
	docker-compose exec symfony php bin/console make:entity

cache_clear:
	docker-compose exec symfony php bin/console cache:clear

install: up vendor migrate seed cache_clear

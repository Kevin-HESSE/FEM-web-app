.PHONY: build clear migrations migrate seed entity up stop dev_deploy

up:
	docker-compose up -d

stop:
	docker-compose stop

build:
	docker-compose build

dev_deploy: clear up migrate seed

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
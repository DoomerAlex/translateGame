init:
	docker-compose build
	docker-compose up -d
	docker-compose exec php-fpm composer install
	docker-compose exec php-fpm php bin/console doctrine:migrations:execute --up 'DoctrineMigrations\Version20240129163404'

build:
	docker-compose build

bash:
	docker-compose exec php-fpm bash

up:
	docker-compose up -d

down:
	docker-compose down

clear-cache:
	docker-compose exec php-fpm php bin/console cache:clear

m-up:
	docker-compose exec php-fpm php bin/console doctrine:migrations:execute --up 'DoctrineMigrations\Version20240129163404'

m-down:
	docker-compose exec php-fpm php bin/console doctrine:migrations:execute --down 'DoctrineMigrations\Version20240129163404'

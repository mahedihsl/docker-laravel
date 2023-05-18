setup-production:
	@make fresh-build
	@make composer-update
	@make npm-update
	@make npm-rundev
	@make prod-env
	@make permission

setup-local:
	@make fresh-build
	@make composer-update
	@make npm-update
	@make npm-rundev
	@make prod-local
	@make permission
	
fresh-build:
	docker compose build --no-cache --force-rm

build:
	docker compose build 

stop:
	docker compose stop

up:
	docker compose up -d

composer-update:
	docker compose run --rm hyperwire-composer install --ignore-platform-reqs 

npm-update:
	docker compose run --rm hyperwire-npm npm install  

npm-rundev:
	docker compose run --rm hyperwire-npm npm run dev  

permission:
	docker exec hyperwire-php bash -c "chown -R root:www-data storage"
	docker exec hyperwire-php bash -c "chown -R root:www-data bootstrap/cache"
	docker exec hyperwire-php bash -c "chmod -R 775 storage"
	docker exec hyperwire-php bash -c "chmod -R 755 bootstrap/cache"
	docker exec hyperwire-php bash -c "php artisan key:generate"

prod-env:
	docker exec hyperwire-php bash -c "cp .env.prod .env"
	
local-env:
	docker exec hyperwire-php bash -c "cp .env.sample .env"

app:
	docker exec -it hyperwire-php bash


setup:
	@make build
	@make composer-update
	@make npm-update
	@make permission

build:
	docker compose build --no-cache --force-rm

stop:
	docker compose stop
up:
	docker compose up -d
composer-update:
	docker compose run --rm composer install --ignore-platform-reqs 
npm-update:
	docker compose run --rm npm npm install  
permission:
	docker exec php bash -c "chown -R root:www-data storage"
	docker exec php bash -c "chown -R root:www-data bootstrap/cache"
	docker exec php bash -c "chmod -R 775 storage"
	docker exec php bash -c "chmod -R 755 bootstrap/cache"
	docker exec php bash -c "cp .env.sample .env"
	docker exec php bash -c "php artisan key:generate"


app:
	docker exec -it php bash
 

	

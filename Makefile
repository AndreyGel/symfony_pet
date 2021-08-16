up:
	docker-compose up -d
build:
	docker-compose up --build -d
down:
	docker-compose down
restart:
	docker-compose down && docker-compose up --build -d
npm-i:
	docker-compose exec node npm install
npm-dev:
	docker-compose exec node npm run dev
perm:
	sudo chgrp -R www-data storage bootstrap/cache
	sudo chmod -R 777 storage/logs
	sudo chmod -R ug+rwx storage bootstrap/cache
	sudo chmod -R 777 resources/lang
test:
	docker-compose exec php-fpm php artisan test
sym:
	docker-compose exec php-fpm /root/.symfony/bin/symfony $(c)
migrate:
	docker-compose exec php-fpm php artisan migrate
exec:
	docker-compose exec php-fpm bash
console:
	docker-compose exec php-fpm php bin/console $(c)
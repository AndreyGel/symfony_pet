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
	docker-compose exec app php artisan test
sym:
	docker-compose exec app /root/.symfony/bin/symfony $(c)
migrate:
	docker-compose exec app php artisan migrate
exec:
	docker-compose exec app bash
console:
	docker-compose exec app php bin/console $(c)
migration:
	docker-compose exec app php bin/console doctrine:migration:$(c)
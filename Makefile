up:
	docker compose up -d --build

down:
	docker compose down

bash:
	docker exec -it siroko_php bash

composer-install:
	docker exec -it siroko_php composer install

symfony:
	docker exec -it siroko_php symfony serve -d

console:
	docker exec -it siroko_php php bin/console

test:
	docker exec -it siroko_php php bin/phpunit
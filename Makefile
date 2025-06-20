DOCKER_EXEC = docker exec
DOCKER_PHP := siroko_php

up:
	docker compose up -d --build

down:
	docker compose down

bash:
	${DOCKER_EXEC} -it ${DOCKER_PHP} bash

composer-install:
	${DOCKER_EXEC} -it ${DOCKER_PHP} composer install

console:
	${DOCKER_EXEC} -it ${DOCKER_PHP} php bin/console

test:
	${DOCKER_EXEC} -it ${DOCKER_PHP} php bin/phpunit

migrations:
	${DOCKER_EXEC} -it ${DOCKER_BE} php bin/console d:m:m

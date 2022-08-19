build:
	docker-compose up --build

up:
	docker-compose up -d

stop:
	docker stop $(docker ps -a -q) && docker system prune -af --volumes

web:
	docker exec -it docker-symfony-mysql-web-1 bash

mysql:
	docker exec -it docker-symfony-mysql-db-1 bash

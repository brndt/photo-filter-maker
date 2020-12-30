current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

.PHONY: build
build: deps security-rules start

.PHONY: deps
deps: composer-install

.PHONY: composer-install composer-update
composer-install: CMD=install
composer-update: CMD=update
composer-install composer-update:
	@docker run --rm --interactive --user $(id -u):$(id -g) \
		--volume $(current-dir)/backend:/app \
		--volume ${COMPOSER_HOME:-$HOME/.composer}:/tmp \
		composer:2 $(CMD) \
			--ignore-platform-reqs \
			--no-ansi \
			--no-scripts \
			--no-interaction

.PHONY: security-rules
security-rules:
	sudo chmod 777 -R backend/public/uploads/

.PHONY: reload
reload:
	@docker-compose exec php-fpm kill -USR2 1
	@docker-compose exec nginx nginx -s reload

.PHONY: start stop destroy
start: CMD=up -d
stop: CMD=stop
destroy: CMD=down

start stop destroy:
	@docker-compose $(CMD)

.PHONY: rebuild
rebuild:
	docker-compose build --pull --force-rm --no-cache
	make deps
	make start
# To get the current directory in Linux, Mac or Windows
current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
SHELL = /bin/sh
RUN_PHP := docker-compose exec php
RUN_SYMFONY := $(RUN_PHP) bin/console

start:
	@docker-compose up -d

restart: stop start

stop:
	@docker-compose down

rebuild:
	@docker-compose up -d --build

exec:
	@docker-compose exec php sh

.PHONY: build
build: composer/install

composer/install: ACTION=install
composer/update: ACTION=update
composer/require: ACTION=require $(module)
composer composer/install composer/update composer/require:
	$(RUN_PHP) composer $(ACTION) --ignore-platform-reqs

cache/clear:
	@$(RUN_SYMFONY) cache:clear

autoload:
	$(RUN_PHP) composer dumpautoload

make/entity:
	$(RUN_SYMFONY) make:entity

migration:
	$(RUN_SYMFONY) make:migration

migrate:
	$(RUN_SYMFONY) doctrine:migrations:migrate

schema/create:
	$(RUN_SYMFONY) doctrine:schema:create

schema/update:
	$(RUN_SYMFONY) doctrine:schema:update --force

phpstan:
	$(RUN_PHP) vendor/bin/phpstan analyse --memory-limit=1g

tools/php-cs-fixer/vendor/bin/php-cs-fixer:
	$(RUN_PHP) composer install --working-dir tools/php-cs-fixer

cs: tools/php-cs-fixer/vendor/bin/php-cs-fixer
	$(RUN_PHP) tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --allow-risky=yes --dry-run -v --diff

cs-fix: tools/php-cs-fixer/vendor/bin/php-cs-fixer
	$(RUN_PHP) tools/php-cs-fixer/vendor/bin/php-cs-fixer fix -v

cs-fix-risky: tools/php-cs-fixer/vendor/bin/php-cs-fixer
	$(RUN_PHP) tools/php-cs-fixer/vendor/bin/php-cs-fixer fix -v --allow-risky=yes

test:
	$(RUN_PHP) bin/phpunit --cache-result-file=var/cache/phpunit/.phpunit.cache
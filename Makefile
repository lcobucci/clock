PARALLELISM := $(shell nproc)

.PHONY: all
all: install phpcbf phpcs phpstan phpunit infection

.PHONY: install
install: vendor/composer/installed.json

vendor/composer/installed.json: composer.json composer.lock
	@composer install $(INSTALL_FLAGS)
	@touch -c composer.json composer.lock vendor/composer/installed.json

.PHONY: phpunit
phpunit:
	@vendor/bin/phpunit

.PHONY: infection
infection:
	@php -d xdebug.mode=coverage vendor/bin/phpunit --coverage-xml=build/coverage-xml --log-junit=build/junit.xml $(PHPUNIT_FLAGS)
	@vendor/bin/infection -v -s --threads=$(PARALLELISM) --coverage=build --skip-initial-tests $(INFECTION_FLAGS)

.PHONY: phpcbf
phpcbf:
	@vendor/bin/phpcbf --parallel=$(PARALLELISM)

.PHONY: phpcs
phpcs:
	@vendor/bin/phpcs --parallel=$(PARALLELISM) $(PHPCS_FLAGS)

.PHONY: phpstan
phpstan:
	@php -d xdebug.mode=off vendor/bin/phpstan analyse


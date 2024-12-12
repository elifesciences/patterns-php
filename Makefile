PROJECT_NAME = patterns-php
.PHONY: build lint phpcs test test-ci update-pattern-library

vendor:
	composer install

test: vendor
	vendor/bin/phpunit

phpcs:
	vendor/bin/phpcs --standard=phpcs.xml.dist --warning-severity=0 -p bin src tests

lint: phpcs
	find src tests -name '*.php' | xargs -L1 php -l

update-pattern-library:
	bin/update

build:
	$(if $(PHP_VERSION),,$(error PHP_VERSION make variable needs to be set))
	docker buildx build --build-arg=PHP_VERSION=$(PHP_VERSION) -t $(PROJECT_NAME):$(PHP_VERSION) .

lint-ci: build
	docker run --rm $(PROJECT_NAME):$(PHP_VERSION) bash -c 'vendor/bin/phpcs --standard=phpcs.xml.dist --warning-severity=0 -p bin src tests'
	docker run --rm $(PROJECT_NAME):$(PHP_VERSION) bash -c 'find src tests -name '*.php' | xargs -L1 php -l'

test-ci: build
	docker run --rm $(PROJECT_NAME):$(PHP_VERSION) bash -c 'vendor/bin/phpunit'

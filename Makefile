.PHONY: lint test

vendor:
	composer install

test: vendor
	vendor/bin/phpunit

lint:
	find src tests -name '*.php' | xargs -L1 php -l

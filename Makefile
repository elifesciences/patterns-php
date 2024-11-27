.PHONY: lint phpcs test update-pattern-library

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

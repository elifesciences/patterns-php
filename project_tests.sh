#!/bin/bash
set -e

: "${dependencies:?Need to set dependencies environment variable}"
if [ "$dependencies" = "lowest" ]; then composer update --prefer-lowest --no-interaction; else composer update --no-interaction; fi;
if [ "$dependencies" = "lowest" ]; then vendor/bin/phpcs --standard=phpcs.xml.dist --warning-severity=0 -p bin src; fi;
if [ "$dependencies" = "lowest" ]; then vendor/bin/phpcs --standard=phpcs.xml.dist --warning-severity=0 -p tests; fi;
vendor/bin/phpunit --log-junit="build/${dependencies}-phpunit.xml"

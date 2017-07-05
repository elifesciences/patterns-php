#!/bin/bash
set -e

: "${dependencies:?Need to set dependencies environment variable}"
if [ "$dependencies" = "lowest" ]; then composer update --prefer-lowest --no-interaction; else composer update --no-interaction; fi;
if [ "$dependencies" = "lowest" ]; then proofreader bin src; fi;
if [ "$dependencies" = "lowest" ]; then proofreader --no-phpcpd tests; fi;
vendor/bin/phpunit --log-junit="build/${dependencies}-phpunit.xml"

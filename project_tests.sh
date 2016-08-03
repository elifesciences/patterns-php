#!/bin/bash
set -e

: "${dependencies:?Need to set dependencies environment variable}"
if [ "$dependencies" = "lowest" ]; then composer1.0 update --prefer-lowest --no-interaction; else composer1.0 update --no-interaction; fi;
if [ "$dependencies" = "lowest" ]; then proofreader bin src tests; fi;
vendor/bin/phpunit --log-junit="build/${dependencies}-phpunit.xml"

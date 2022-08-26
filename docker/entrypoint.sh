#!/usr/bin/env bash

# -n Do not ask any interactive question
composer install -n
# bin/console doc:mig:mig --no-interaction
# bin/console doc:fix:load --no-interaction

exec "$@"

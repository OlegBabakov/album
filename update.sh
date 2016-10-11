#!/bin/sh

echo 'script starts'
git pull
php app/console assets:install --symlink
php app/console cache:clear --env=prod
php app/console cache:warmup --env=prod
echo 'script finished'
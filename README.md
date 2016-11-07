album
=====

Project prepare:
composer install
permissions to: app/cache
permissions to: app/logs

Deploying:
php app/console doctrine:schema:update 
php app/console doctrine:fixtures:load --env=prod
php app/console cache:clear --env=prod
php app/console cache:warmup --env=prod


Testing:
php phpunit.phar


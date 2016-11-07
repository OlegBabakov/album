album
=====

Project prepare:
composer install
permissions to: app/cache
permissions to: app/logs
permissions to: web/cache
permissions to: web/uploads
php app/console doctrine:schema:update 
Copy "gallery_fixtures_web_path" from parameters.yml.dist
php app/console cache:clear --env=prod
php app/console doctrine:fixtures:load --env=prod
php app/console cache:warmup --env=prod


Testing:
php phpunit.phar


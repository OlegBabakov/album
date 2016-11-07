# Album

## Project prepare:
- composer install
- Read: http://symfony.com/doc/current/setup/file_permissions.html to set ACL permissions on Linux/BSD
- write permissions to: app/cache
- write permissions to: app/logs
- write permissions to: web/cache
- write permissions to: web/uploads
<br /><br />
- php app/console doctrine:schema:update --force 
- Copy "gallery_fixtures_web_path" from parameters.yml.dist
- php app/console cache:clear --env=prod
- php app/console doctrine:fixtures:load --env=prod
- php app/console cache:warmup --env=prod

## Testing:
- php phpunit.phar


album
=====

Deploying:
php app/console doctrine:schema:update 
php app/console doctrine:fixtures:load --env=prod
php app/console cache:clear --env=prod
php app/console cache:warmup --env=prod


Testing:
This project contains PHPUnit 4.* version,
because newest one tries to use yml parser from Symfony 3 


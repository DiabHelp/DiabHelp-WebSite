DiabHelp-sf2
============

A Symfony project created on October 12, 2015, 5:57 pm.


### Quand vous clonez / pull ou autre :

### Update des dépendances :
php composer.phar update

### Si la db est inexistante :
php app/console doctrine:database:create

### Sous Linux :
php app/console doctrine:schema:update DHPlatformBundle --dump-sql
php app/console doctrine:schema:update DHPlatformBundle --force
php app/console assets:install --symlink web

### Sous Windows :
php app/console doctrine:schema:update --dump-sql
php app/console doctrine:schema:update --force
php app/console assets:install web

### Réécriture des assets (fichier CSS du cache Synfony2)
php app/console assetic:dump web

404 + 500

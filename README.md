DiabHelp-sf2
============

# Quand vous clonez / pull ou autre :

  ### Update des dépendances :
  `php composer.phar update`
  
  ### Si la db mysql est inexistante :
  `php app/console doctrine:database:create`
  
  ## Pareil pour sqlite :
  `sqlite3 app/db/data.db3 "create table aTable(field1 int); drop table aTable;"`
  
  `php app/console doctrine:database:create`
  
  ### Sous Linux :
  `php app/console doctrine:schema:update DHPlatformBundle --dump-sql`
  
  `php app/console doctrine:schema:update DHPlatformBundle --force`
  
  `php app/console assets:install --symlink web`
  
  ### Sous Windows :
  `php app/console doctrine:schema:update --dump-sql`
  
  `php app/console doctrine:schema:update --force`
  
  ### Réécriture des assets (fichier CSS du cache Synfony2)
  `php app/console assets:install web`
  
  `php app/console assetic:dump web`
  
  ### Pour la génération de pdf :
  Linux : 
  `sudo apt-get install wkhtmltopdf`
  
  MacOS :
  `brew install Caskroom/cask/wkhtmltopdf`
  
  Windows :
    télécharger le .exe depuis http://wkhtmltopdf.org/downloads.html
    Ajouter le path voulu dans les variables d'environnement / appeler le path de l'exécutable
  
  ### Todo
  https://docs.google.com/document/d/12ZC_DrxtdDA7C8SDdoGOTVv3lv-NJeWLbbzEAqKxJCk/edit
  Error 404 + 500
  export pdf -> mail
  connexion username/mail
  inscription rest POST

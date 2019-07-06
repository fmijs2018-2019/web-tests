# web-tests

### Set up
1. създаване на база – изпълнете скрипта seed.sql, който се намира в ./sql директорията
2. инсталиране на Composer – изпълнете в директорията на проекта следните команди:
  * php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" 
  * php -r "if (hash_file('sha384', 'composer-setup.php') ===   '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" 
  * php composer-setup.php 
  * php -r "unlink('composer-setup.php');"
3. инсталиране на пакети – изпълнете в директорията на проекта:
  * php composer.phar install
4. изпълнете в папката на проекта:
  * php composer.phar dump 

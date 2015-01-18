HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console assets:install --symlink
php app/console assetic:dump
php app/console fos:user:create admin admin@admin.com admin --super-admin
php app/console sonata:page:create-site --enabled=true --name=localhost --locale=- --host=localhost --relativePath=/ --enabledFrom=now --enabledTo="+10 years" --default=true --no-confirmation=true
php app/console sonata:page:update-core-routes --site=all
php app/console sonata:page:create-snapshots --site=all
php app/console cache:clear
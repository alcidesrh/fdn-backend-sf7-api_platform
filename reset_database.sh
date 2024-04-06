#!/bin/bash
if ! hash symfony 2>/dev/null;then
php bin/console doctrine:database:drop -nf --if-exists --quiet;
php bin/console doctrine:database:create -n;
rm -r migrations/*;
php bin/console doctrine:migrations:diff -n;
php bin/console doctrine:migrations:migrate -n
else
symfony console doctrine:database:drop -nf --if-exists;
symfony console doctrine:database:create -n;
rm -r migrations/*;
symfony console doctrine:migrations:diff -n;
symfony console doctrine:migrations:migrate -n
fi

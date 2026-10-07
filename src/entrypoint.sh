#!/bin/bash
set -e

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --force

# Cria a pasta /data exigida pela prova e dá permissão
mkdir -p /data
chmod 777 /data

# Cria o arquivo do banco no volume esperado
touch /data/database.sqlite
chmod 777 /data/database.sqlite

# Modifica o .env dinamicamente para usar o banco em /data
sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=sqlite\nDB_DATABASE=\/data\/database.sqlite/' .env

chmod -R 777 storage bootstrap/cache

php artisan migrate --force

# Sobe o servidor na porta 8080
exec php artisan serve --host=0.0.0.0 --port=8080

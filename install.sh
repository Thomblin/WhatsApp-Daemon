#!/usr/bin/env bash

# install missing dependencies

cd /vagrant/php
php composer.phar install

# create a mysql database

mysql -uroot -p123 -e "CREATE DATABASE whatsapp"

# migrate database

php vendor/bin/phinx migrate

# WhatsApp registration

php whatsapp/cli/register.php

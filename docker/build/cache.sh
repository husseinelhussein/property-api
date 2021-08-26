#!/bin/bash

echo "composer dump-autoload"
composer dump-autoload;

echo "running php bin/console cache:clear";
php bin/console cache:clear
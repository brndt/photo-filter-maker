#!/usr/bin/env bash
sleep 10;
/var/www/html/bin/console doctrine:schema:update --force

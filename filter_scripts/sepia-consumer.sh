#!/usr/bin/env bash
sleep 10;
/var/www/html/bin/console messenger:consume sepia -vv >&1;

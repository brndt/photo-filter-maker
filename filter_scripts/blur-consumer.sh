#!/usr/bin/env bash
sleep 10;
/var/www/html/bin/console messenger:consume blur -vv >&1;

#!/bin/sh

while true
do
    curl --silent --insecure 'elasticsearch:9200/_cluster/health?wait_for_status=green' > /dev/null
    verifier=$?
    if [ 0 = $verifier ]
        then
	    /var/www/html/bin/console doctrine:schema:update --force
            /var/www/html/bin/console fos:elastica:populate
            break
        else
            echo "ES is not running yet"
            sleep 5
    fi
done

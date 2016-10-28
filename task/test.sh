#!/bin/sh
cd /data/web/userauth/public
for i in {1..100}
do
    /usr/bin/php -q cli.php test/task/id/$i &
done


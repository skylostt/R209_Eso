#!/bin/sh

while true
do
    username=$(cat /proc/sys/kernel/random/uuid | md5sum | cut -d ' ' -f 1 | cut -c1-8)
    echo "$username"
    curl -X 'POST' 'http://prjwww.univ-pau.fr/~mmotz/registerRequest.php' -d username="$username" -d email="${username}@gmail.com" -d password="$username"
done

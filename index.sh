#!/bin/bash

sqlite3 packages.db 'delete from packages;'

pkgs_dir="/home/justin/packages/packages"

cd ${pkgs_dir}

for package in $(find . -iname monitoring.yml)
  do
  bash /home/justin/SolusRepo/process.sh ${package}
  sleep 2
done

rsync -av packages.db justin@192.168.0.5:/var/www/html/solus-versions/.

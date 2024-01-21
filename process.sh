#!/bin/bash

source ~/Scripts/bash_core

pkgs_dir="/home/justin/packages/packages"

input=${@}
package=$(echo ${input} | cut -d / -f 3)
letter=$(echo ${input} | cut -d / -f 2)
current_version=$(cat ${pkgs_dir}/${letter}/${package}/package.yml | yq .version)
url=$(cat ${pkgs_dir}/${letter}/${package}/package.yml | yq .homepage)

if [[ ${current_version} == "" ]]
  then
    echo "Can't determine ${package} version number, aborting."
    exit 1
fi
rm_id=$(cat ${pkgs_dir}/${letter}/${package}/monitoring.yml | yq .releases.id)
#echo RMID ${rm_id}
if [[ ${rm_id} == "" ]]
  then
    echo "Can't determine ${package} release monitoring ID, aborting."
    exit 1
fi

rm_ver=$(curl -s "https://release-monitoring.org/api/v2/versions/?project_id=${rm_id}" | jq -r .stable_versions[0])

maintainer="To be Added"

if [[ ${current_version} == ${rm_ver} ]]
  then
    outofdate="✅"
  else
    outofdate="🔼"
fi

sqlite3 /home/justin/SolusRepo/packages.db "insert or replace into packages (package, sver, rmver, maintainer, outofdate, homepage, letter, rm_id) values ('${package}', '${current_version}', '${rm_ver}', '${maintainer}', '${outofdate}', '${url}', '${letter}', '${rm_id}');"

#! /bin/bash

wget https://github.com/paimpozhil/MageFirewall/archive/master.zip
unzip master.zip
rsync -avz ./MageFirewall-master/ ./ 
rm -Rf master.zip ./MageFirewall-master

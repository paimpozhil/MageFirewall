#! /bin/bash

wget https://github.com/paimpozhil/MageFirewall/archive/prealpha.zip
unzip prealpha.zip
rsync -avz ./MageFirewall-prealpha/ ./ 
rm -Rf master.zip ./MageFirewall-prealpha

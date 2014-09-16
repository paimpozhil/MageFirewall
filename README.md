MageFirewall
============

Magento Firewall for securing your e-commerce system. 
Tested to work with Magento 1.6 and above.

###Features

* Neat Dashboard
* Alert / List about recently modified files which has potentially dangerous code
* Incorporates rules from NinjaFirewall to analyze / stop the attackers
* Scan your magento from internet for security issues on your magento.
* Scans your magento installation from within and checks if you have unpatched security issues.
* Has Whitelisting/Blacklisting 
* Prevents bruteforcing on your admin credentials/ adds attackers to black list
* Debug/Diagnostics/Ninja Firewall Consoles availabe

More information & support available at http://magefirewall.com


## Install

#### Shell

change directory to your magento directory 

```
cd /path/to/magento
curl https://raw.githubusercontent.com/paimpozhil/MageFirewall/master/install.sh | sh
```

##### FTP
Download the https://github.com/paimpozhil/MageFirewall/archive/master.zip
and extract the folder called MageFirewall-master.. upload contents to the root folder of your Magento installation.

## Support 

Need support?

Please buy Installation/support from from http://magefirewall.com

## Beta

MageFirewall is in Beta, so please use carefully.
You should test this extension in a testing / staging enivornment before pushing to a live site.

We accept no responsibility if this plugin causes any downtime to your store or locks you out from the Admin area.
If you are concerned about errors that may occur we offer a paid support service.

## Credits

Thanks to NinjaFirewall , We used rules/some code from their free/opensource version.

###### http://ninjafirewall.com/

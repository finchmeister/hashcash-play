#!/usr/bin/env bash

sudo apt update
sudo apt install php git -y


curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

#//      "sudo apt -y install software-properties-common",
#//      "sudo add-apt-repository ppa:ondrej/php",
#//      "sudo apt-get update",
#//      "sudo apt -y install php7.4 git",
#//      "curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer",


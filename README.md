# About

This project uses the whatsapp/chat-api in order to connect a daemon with your mobile phone. 
All received and sent messages are stored in a mysql database and can be used for further work easily.
The daemon and a simple user interface is provided.

* https://github.com/WHAnonymous/Chat-API is used to connect to your whatsapp account
* https://github.com/bcosca/fatfree provides a simple framework and user interface
* https://github.com/PhiloNL/Laravel-Blade provides the Laravel templating system
* https://github.com/shaneharter/PHP-Daemon is used to send and receive all whatsapp messages 
* https://github.com/robmorgan/phinx migrates the database

**Caution:** You can not use nor verify your whatsapp account on your mobile phone and in the daemon at the same time!

# Prerequisites

You need these packages on your host system in order to start this project in a virtual environment.
If you do not want to run a virtual environment, you need to install all dependencies that can be found in the ansible folder.

* virtualbox: https://www.virtualbox.org/wiki/Downloads
* vagrant: https://www.vagrantup.com/downloads.html
* ansible: http://docs.ansible.com/ansible/intro_installation.html#getting-ansible  
    
# Init environment

Download this project and initialize the virtual environment using vagrant

    $ vagrant up

# Setup WhatsApp communication

create a new basic configuration and connect your mobile phone
    
    $ vagrant ssh
    $ cd /vagrant
    $ ./install.sh
    

you can start the daemon now, to receive and send messages

    $ sudo service whatsapp-daemon start
        
or you run the script on your own

    $ cd /vagrant/php/whatsapp/Daemon
    $ sudo php run.php
    
logs can be found in either way at

* /var/log/phpcli
* /var/log/daemons/whatsapp/
    
# Run in web browser

open `http://192.168.33.99` in your browser. 
If your connected whatsapp account receives a new message it will be displayed and you may answer.
     
# Important files and folders
```
│   README.md - instructions
│   install.sh - install dependencies, connect to mobile phone
│   Vagrantfile - vagrant configuration
│
└───ansible - ansible configuration files to provision your environment
└───php
    |   composer.json - php dependencies
    |   index.php - routing
    |   phinx.yml - DB configuration (created by ansible)
    └───base - contains general classes
    └───vendor  - php externals
    └───whatsapp
        └───cli - CLI executables
        └───Client - Whatsapp helper that are used for communication
        └───Controller - Controller for our web interface 
        └───Daemon - Whatsapp daemon which is used to handle all messages
        └───Db - DB migrations and models
        └───Log - log classes
        └───Repository - classes containing db queries
└───templates 
└──────cache - Blade cache
└──────views - Blade templates
└───www
    │   index.php - Nginx points to this file
    ├───css - global css files
    └───js - global js files
```
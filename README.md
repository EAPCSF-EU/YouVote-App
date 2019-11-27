# Voting app for the Hackathon

## Requirements
- PHP v7 (Yii2 framework)
- MySQL v5+ (config file `common/config/main-local.php`)
- MailGun for mail (config file `common/config/params.php`)

NB: For more detailed list along with running a check aganst the requirements, please run the /requirements.php

## Installation
Once you download the source code, run `composer install` command. If you don't have Composer app, it is required to install composer first. 
You can find initial database in  `db` folder at root directory. Import the database.

*Virtual host*
If you are using apache, DocumentRoot must show `web` folder at the root directory of the project. 

```
<VirtualHost *:80>
    ServerAdmin admin@example.com
    ServerName voting.app
    DocumentRoot /var/www/html/voting.app/public_html/web
        <Directory "/var/www/html/my.ggs.uz/public_html">
                AllowOverride All
        </Directory>
</VirtualHost>
```
## Configuration
Find `main-local.php` file under `common/config` directory and update database credentials. If that file doesn't exists, 
pleas create it and add following code: 

```
<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=dbname',
            'username' => 'username',
            'password' => 'password',
            'charset' => 'utf8',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '82VpS1Xk8wr-kfvmsIRXrFuEipvrVh-j',
        ]
    ]
];
```


## Voting app client side 
http://localhost/

## Admin panel

http://localhost/admin

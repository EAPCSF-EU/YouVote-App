# YouVote App

## General Info

The public release of a web application ‘YouVote’ for public voting and
evaluation of competitions / contests / hackathons developed within the EU-funded ‘Eastern
Partnership Civil Society Facility –Regional Actions’ project: http://eapcivilsociety.eu/

## Table of Contents
1. Description
2. License
3. Installation
4. User Guidelines

## 1. Description

YouVote is an open source web-based application that enables users to create ratings and voting
contests, and view the results in real time. It has been developed within the EU-funded ‘Eastern
Partnership Civil Society Facility –Regional Actions’ project, for the needs of its annual EaP Civil
Society Hackathons.
YouVote is free to download and run on your server. It allows the audience vote for contenders live
on their smartphones, tablets and desktops, and there is nothing voters need to download or install.
YouVote is also designed to make voting results transparent for all parties while keeping individual
choices private: after the voting ends, voters will see the average scores for each contender, but not
individual votes.

Other features of the YouVote application are:

- user verification / authorisation by email through an invitation link, allowing organisers
decide who can vote;
- one-time voting for each users, to avoid inflated ratings;
- unlimited number of contests, contenders and questions or criteria to evaluate them;
- adjustable evaluation scale (from 1 to 100), to make evaluations as precise as needed;
- complete and detailed voting results (total, average and for each contender) that organisers
can download in excel format;
- settable voting time for each contest, with voting automatically opening and closing when
needed;
- easy-to-use admin dashboard that allows organisers customise each contest with a photo,
title and description.
As a special feature, the YouVote application allows organisers to disable voting for one’s own
project, by adding voter(s) to the relevant project team(s).

## 2. License

YouVote is licensed under GNU General Public License v3.0 / Creative Commons Attribution Share
Alike 4.0 as its equivalent: licensees have the right to run, study, share, and modify the software,
under the condition of making available the source code of licensed works and modifications under
the same conditions. The attribution shall be as follows:
- If you run the YouVote application for your purposes without modifications, or share with
other users, we would appreciate that you acknowledge this by adding the phrase: ‘The
YouVote application was developed with the financial support of the European Union’.
- If you modify the software and use the modified version for your purposes, or publish it
further, we would appreciate that you acknowledge the original product by adding the
phrase: ‘This &lt;NAME&gt; application uses the source code of the YouVote application
developed with the financial support of the European Union’.


## 3. Installation

### 3.1 Server Requirements 

Following tools were used to develop the app:
- PHP v7 (Yii2 Framework)
- MySQL v5+ (config file `common/config/main-local.php`)
- MailGun for mail (config file `common/config/params.php`)

To check your server configuration against Yii Application requirements, you can run the requirements checker http://localhost/requirements.php to see if anything is missing. A sample of the valid environment can be seen here http://vote.eapcivilsociety.eu/requirements.php. More details on the requirements for the Yii Framework can be found here: https://www.yiiframework.com/doc/guide/2.0/en 

Mailgun has a free plan if number of emails sent falls into limit of 10K/month: https://www.mailgun.com/pricing/

### 3.2 Installation 

Once you download the source code, run `composer install` command. If you don't have the Composer app, please install it first. 
You can find the initial database in the `db` folder at the root directory. Import the database.

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

<?php

/*return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];*/

return [
    'class'    => 'yii\db\Connection',
    'dsn'      => 'sqlite:@runtime/main-db.sqlite',
    'username' => 'root',
    'password' => '',
    'charset'  => 'utf8',
];
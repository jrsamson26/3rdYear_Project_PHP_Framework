<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Itb\Model\User;

define('DB_HOST','localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'itb');

$jr = new User();
$jr->setUsername('jr');
$jr->setPassword('samson');
$jr->setRole(User::ROLE_ADMIN);

$karen = new User();
$karen->setUsername('karen');
$karen->setPassword('umali');
$karen->setRole(User::ROLE_USER);

$admin = new User();
$admin->setUsername('admin');
$admin->setPassword('admin');
$admin->setRole(User::ROLE_ADMIN);

$darren= new User();
$darren->setUsername('darren');
$darren->setPassword('cosgrave');
$darren->setRole(User::ROLE_PROJECT_LEADER);

$charles= new User();
$charles->setUsername('charles');
$charles->setPassword('john');
$charles->setRole(User::ROLE_PROJECT_SECRETARY);

User::insert($jr);
User::insert($karen);
User::insert($admin);
User::insert($darren);
User::insert($charles);


$users = User::getAll();

var_dump($users);
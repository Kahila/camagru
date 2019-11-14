<?php
require_once 'core/init.php';

$user = new User();
$user->logout();
redirect::go_to('index.php');
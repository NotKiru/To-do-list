<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
    $_SESSION['isLoggedIn'] = false;
}
if(!isset($_SESSION['username'])) {
    $_SESSION['username'] = '';
}
if(!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light';
}

include_once('autoloader.php');
include_once('config.php');

if (isset($_GET['cmd'])){
    $cmd = $_GET['cmd'];
} else {
    $cmd="";
}

$Controller = new \Application\Controller($cmd,$config);
$db = new \Drivers\DataBase($config['db']);
$ClassName = $Controller->GetObjectName();

if (class_exists($ClassName)){
    $Page = new $ClassName($cmd,$config);
    $Page->ObjectRegister($Controller);
    $Page->ObjectRegister($db);
    $Page->Show();
} else {
    $Controller->RedirectPage("/Web/Start",1);
}
// nau.zse-e.edu.pl/4lgr1
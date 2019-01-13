<?php ini_set("display_errors", 1);

require_once (__DIR__."/../vendor/autoload.php");
require_once (__DIR__."/constructor.php");

$session->start();
$session->set("str_test", "Hello World");
$session->commit();
header('Location: test01.php');
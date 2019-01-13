<?php ini_set("display_errors", 1);

require_once (__DIR__."/../vendor/autoload.php");
require_once (__DIR__."/constructor.php");

$session->start();
$session->set('str_test', "Hello World");
$session->commit();

$session->start();
$session->set('str_test', "Bye World");
$session->abort();

$session->start();

echo "Test 06: ";

$str_test = $session->get('str_test');

if ($str_test != "Hello World")
{
    die(" - Failed - str_tests still 'Bye World' after abort()");
}

echo "Passed!";

header('Location: success.html');
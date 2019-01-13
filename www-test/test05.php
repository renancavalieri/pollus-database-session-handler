<?php ini_set("display_errors", 1);

require_once (__DIR__."/../vendor/autoload.php");

use Pollus\ImprovedSession\ImprovedSession;

$session = new ImprovedSession();
$session->name("test_session");
$session->start();
$session->destroy();
$session->start();

echo "Test 05: ";

if ($str_test == "Hello World")
{
    die(" - Failed - str_tests still 'Hello World' after destroy()");
}

echo "Passed!";

header('Location: test06.php');
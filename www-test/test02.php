<?php ini_set("display_errors", 1);

require_once (__DIR__."/../vendor/autoload.php");
require_once (__DIR__."/constructor.php");

$session->start();
$old_id = $session->id();
session_regenerate_id(true);
echo "Test 02: ";

if ($old_id === $session->id())
{
    die("- Failed: The session ID was not regenerated");
}

$str_test = $session->get("str_test");

if ($str_test == "Hello World")
{
    echo $str_test . " - Passed";
}
else
{
    var_dump($_SESSION);
    die("- Failed: The value of str_test was not 'Hello World' after regenerateId()");
}

header('Location: test03.php?old_id=' . $old_id);
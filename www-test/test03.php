<?php ini_set("display_errors", 1);

require_once (__DIR__."/../vendor/autoload.php");
require_once (__DIR__."/constructor.php");

$session->start();

echo "Test 03: ";

$old_id = $_GET["old_id"] ?? null;

if ($old_id === null)
{
    die("- Failed: The variable old_id was not present in this request");
}
else if ($old_id === $session->id())
{
    die("- Failed: The session ID was regenerated but this request has loaded the old value");
}

$session->unset();
$str_test = $session->get("str_test");

if ($str_test == null)
{
    echo $str_test . " - Passed";
}
else
{
    var_dump($_SESSION);
    die("- Failed: The value of str_test was not null after unset()");
}

header('Location: test04.php');
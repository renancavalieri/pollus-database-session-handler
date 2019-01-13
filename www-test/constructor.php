<?php

use Pollus\DatabaseSessionHandler\Adapters\MySQLAdapter;
use Pollus\DatabaseSessionHandler\DatabaseSessionHandler;
use Pollus\DatabaseSessionHandler\StrictSession;

$pdo = new \PDO("mysql:host=127.0.0.1;dbname=database_session_handler_test", "root", "root", 
        [ \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION ]);

$handler = new DatabaseSessionHandler(new MySQLAdapter($pdo));

// Optional
$options = [

    // How much should the session last in minutes without user activity? (in minutes)
    'lifetime'     => 60 * 24,

    // path, domain, secure, httponly: Options for the session cookie.
    'path'         => '/',
    'domain'       => null,
    'secure'       => false,
    'httponly'     => true,

    // name: Name for the session cookie. Defaults to PHPSESSID.
    'name'         => "PHPSESSION",

    // autorefresh: true if you want session to be refresh when user activity is made.
    'autorefresh'  => true,

    // ini_settings: Associative array of custom session configuration.
    'ini_settings' => [],
];

$session = new StrictSession($handler, $options);
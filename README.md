# Pollus - Database Session Handler

This package provides a simple and flexible Database Session Handler.

Currently it supports only MySQL, but it can support any database by implementing the *DatabaseAdapterInterface*

The default MySQL adapter supports row locking using pessimistic lock, however it can be disabled if you need to.

Also this package provides the **StrictSession** object, which is an implementation of **SessionInterface** from [SessionWrapper package](https://github.com/renancavalieri/pollus-session-wrapper) and extends the funcionality of [ImprovedSession](https://github.com/renancavalieri/improved-session), it enforces the use of strict sessions even if disabled on php.ini. 

## Usage

    composer require pollus/session-database-handler

Create the following table on your database:

```sql
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(512) NOT NULL,
  `session_data` MEDIUMBLOB NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
```

And then setup the session handler.

```php
use Pollus\DatabaseSessionHandler\Adapters\MySQLAdapter;
use Pollus\DatabaseSessionHandler\DatabaseSessionHandler;
use Pollus\DatabaseSessionHandler\SessionManager;

// This connection should be used exclusively to the adapter
$pdo = new \PDO("mysql:host=127.0.0.1;dbname=DB_NAME", "DB_USER", "DB_PASSWORD"); 

// Instances the DatabaseSessionHandler with MySQLAdapter
$handler = new DatabaseSessionHandler(new MySQLAdapter($pdo));

// Options
$options = [

    // How much should the session last in minutes without user activity? (in minutes)
    'lifetime'     => 60 * 24,

    // path, domain, secure, httponly: Options for the session cookie.
    'path'         => '/',
    'domain'       => null,
    'secure'       => false,
    'httponly'     => true,

    // name: Name for the session cookie. Defaults to PHPSESSION.
    'name'         => "PHPSESSION",

    // autorefresh: true if you want session to be refresh when user activity is made.
    'autorefresh'  => true,

    // ini_settings: Associative array of custom session configuration.
    'ini_settings' => [],
];

$session = new StrictSession($handler, $options);

// Starts the session
$session->start();
$session->set("test", "Hello World");
$session->get("test"); // Hello World
```

Its possible configure the **MySQLAdapter** to use another table, change the length of session ID or to disable row locking.

**TODO:** More tests are needed to ensure the functionality of this package.

#MIT License

Copyright (c) 2018 Renan Cavalieri

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

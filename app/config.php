<?php
use \app\db\MySQL;

define('ROOT_PATH', __DIR__ . '/..');

define('DB_NAME', 'test_searates');
define('DB_USER', 'test');
define('DB_PASS', 'qwerty');
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_DRIVER', MySQL::class);
define('ICONTEINERS_LOGIN', 'test@example.com');
define('ICONTEINERS_PASS', 'qwerty');

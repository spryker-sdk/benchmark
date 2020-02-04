<?php

require_once 'vendor/autoload.php';

define('YVES_BASE_URL', getenv("GLUE") ?: 'http://de.suite-nonsplit.local');
define('GLUE_BASE_URL', getenv("GLUE") ?: 'http://glue.de.suite-nonsplit.local');
define('COOKIE', getenv("COOKIE") ?: 'www-de-suite-local=866c6099f81bbb1a10fed11d61f75323');

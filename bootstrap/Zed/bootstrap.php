<?php

use Spryker\Shared\Config\Application\Environment;
use Spryker\Shared\ErrorHandler\ErrorHandlerEnvironment;
use Spryker\Zed\Application\Communication\ZedBootstrap;

define('APPLICATION', 'ZED');
defined('APPLICATION_ROOT_DIR') || define('APPLICATION_ROOT_DIR', realpath(__DIR__ . '/../../../../../..'));

require_once APPLICATION_ROOT_DIR . '/vendor/autoload.php';

Environment::initialize();

$errorHandlerEnvironment = new ErrorHandlerEnvironment();
$errorHandlerEnvironment->initialize();

$bootstrap = new class extends ZedBootstrap
{
};

$bootstrap->boot();

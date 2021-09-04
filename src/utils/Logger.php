<?php

namespace Webfoto\Core\Utils;

use Monolog;

$__webfoto_core_logger = new Monolog\Logger('webfoto');
$__webfoto_core_logger->pushHandler(new Monolog\Handler\StreamHandler('webfoto.log'));

class Logger {
    public static ?Monolog\Logger $logger = null;
}
Logger::$logger = $__webfoto_core_logger;

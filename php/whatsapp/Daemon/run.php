#!/usr/bin/php
<?php
require_once 'config.php';
#require_once 'error_handlers.php';

require_once __DIR__ . '/../../vendor/autoload.php';

use Thomblin\Whatsapp\Daemon\Daemon;

Daemon::getInstance()->run();
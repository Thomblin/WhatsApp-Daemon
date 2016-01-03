<?php
require 'vendor/autoload.php';

use Philo\Blade\Blade;

$f3 = Base::instance();

$f3->set('AUTOLOAD', 'php/');

$views = realpath(__DIR__ . '/../templates/views');
$cache = realpath(__DIR__ . '/../templates/cache');

$f3->set('BLADE', new Blade($views, $cache));

$f3->route(
    'GET /',
    array(new Thomblin\Whatsapp\Controller\Index($f3), 'get')
);
$f3->map(
    '/messages',
    new Thomblin\Whatsapp\Controller\Messages($f3)
);

$f3->run();
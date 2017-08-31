<?php

// Dependency Injection Container
$container = $app->getContainer();

// Log configuration
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('slim_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

// Eloquent Configuration
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container->get('settings')['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/uploadimage/view', App\Controllers\UploadImageController::class.':view');
$app->post('/uploadimage/upload', App\Controllers\UploadImageController::class.':upload');

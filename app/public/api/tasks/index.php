<?php

require_once '../../../vendor/autoload.php';

use DockerizedPhp\TaskManager;
use DockerizedPhp\Database\Database;
use DockerizedPhp\Config\Config;

$configData = require '../../../config/config.php';
$config = new Config($configData);
$database = new Database($config->get('database'));
$taskManager = new TaskManager($database);

// Aquí va la lógica para manejar las solicitudes HTTP (GET, POST, PUT, DELETE)

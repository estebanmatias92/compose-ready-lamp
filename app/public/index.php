<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DockerizedPhp\App;
use DockerizedPhp\Config\Config;
use DockerizedPhp\Database\Database;
use DockerizedPhp\TaskManager;

$configData = require __DIR__ . '/../config/config.php';
$config = new Config($configData);
$database = new Database($config->get('database'));
$taskManager = new TaskManager($database);

$app = new App($config);
$app->init();

// Aquí puedes manejar las solicitudes AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $task = new \DockerizedPhp\Model\Task($data['title'], $data['description']);
    $taskManager->addTask($task);
    echo json_encode(['message' => 'Task added successfully']);
    exit;
}

// Puedes expandir esto para manejar otros tipos de solicitudes, como GET, PUT, DELETE

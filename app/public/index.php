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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TODO App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="main.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>TODO App</h1>
        <form id="task-form">
            <div class="form-group">
                <input type="text" id="title" class="form-control" placeholder="Title" required>
            </div>
            <div class="form-group">
                <textarea id="description" class="form-control" placeholder="Description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>
        <div id="tasks" class="mt-3"></div>
    </div>
    
    <?php phpinfo(); ?>
</body>
</html>

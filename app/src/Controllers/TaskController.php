<?php

namespace DockerizedPhp;

use DockerizedPhp\Database\Database;
use DockerizedPhp\Models\Task;
use PDO;

class TaskManager {
    private $db;

    public function __construct(Database $database) {
        $this->db = $database->getConnection();
    }

    public function addTask(Task $task) {
        $query = "INSERT INTO tasks (title, description, isComplete) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$task->title, $task->description, $task->isComplete]);
        return $this->db->lastInsertId();
    }

    public function getTasks() {
        $query = "SELECT * FROM tasks";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTask($id) {
        $query = "SELECT * FROM tasks WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTask($id, Task $task) {
        $query = "UPDATE tasks SET title = ?, description = ?, isComplete = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$task->title, $task->description, $task->isComplete, $id]);
    }

    public function deleteTask($id) {
        $query = "DELETE FROM tasks WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }
}


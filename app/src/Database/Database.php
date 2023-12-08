<?php

namespace DockerizedPhp\Database;

use PDO;

class Database {
    private $host;
    private $db;
    private $user;
    private $pass;

    public function __construct($config) {
        $this->host = $config['host'];
        $this->db = $config['name'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
    }

    public function getConnection() {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
        try {
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}

<?php

namespace DockerizedPhp\Models;

class Task {
    public $id;
    public $title;
    public $description;
    public $isComplete;

    public function __construct($title, $description, $isComplete = false) {
        $this->title = $title;
        $this->description = $description;
        $this->isComplete = $isComplete;
    }
}

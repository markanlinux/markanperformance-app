<?php

namespace App\Core;

use App\Config\Database;

abstract class Model
{
    protected \mysqli $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }
}

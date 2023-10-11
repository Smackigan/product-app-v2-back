<?php

require_once '../config/db_config.php';



class DB
{
    protected $conn;

    public function __construct()
    {
        error_log("connecting to db");
        $this->conn = $this->connect();
    }

    public function connect()
    {

        $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (mysqli_connect_errno()) {
            die('DB connection error: ' . mysqli_connect_error());
        }

        return $conn;
    }

    public function getConnection($sql)
    {
        if (!$this->conn) {
            die('No DB connection');
        }

        $stmt = mysqli_prepare($this->conn, $sql);

        if (!$stmt) {
            die('Failed to prepare stmt: ' . mysqli_error($this->conn));
        }

        return $stmt;
    }
}

<?php

namespace Laramus\Liberius\Ancient;

require __DIR__ . DIRECTORY_SEPARATOR . 'parseEnv.php';

class DBCon {
    protected $dbh; // database handler

    public function __construct() {
        $db_host = $_ENV['DB_HOST'];
        $db_username = $_ENV['DB_USERNAME'];
        $db_password = $_ENV['DB_PASSWORD'];
        $db_name = $_ENV['DB_NAME'];

        $dsn = "mysql:host=$db_host;dbname=$db_name";

        $option = [
            \PDO::ATTR_PERSISTENT => true, // connection to database stay active
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new \PDO($dsn, $db_username, $db_password, $option);
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
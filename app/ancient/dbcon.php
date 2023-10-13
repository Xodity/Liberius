<?php

require __DIR__ . '/parseEnv.php';
require __DIR__ . '../../models/User.php';

class Database {
    private $pdo;

    public function __construct() {
        $db_host = $_ENV['DB_HOST'];
        $db_username = $_ENV['DB_USERNAME'];
        $db_password = $_ENV['DB_PASSWORD'];
        $db_name = $_ENV['DB_NAME'];

        try {
            $this->pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}

$database = new Database();
$pdo = $database->getConnection();

$userModel = new UserModel($pdo);

$data = $userModel->getActiveUsers();

?>

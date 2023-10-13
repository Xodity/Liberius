<?php 
namespace Laramus\Liberius\Ancient;

class Model {
    protected $pdo;
    protected $table;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->table = $this->getTableName();
    }

    private function getTableName() {
        // Get the base name of the current file
        $fileName = basename(get_called_class(), '.php');

        // Convert camelCase to snake_case (if needed)
        $tableName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $fileName));

        return $tableName;
    }


    public function getAll() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM $this->table");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

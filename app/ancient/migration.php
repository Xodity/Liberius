<?php
require 'vendor/autoload.php';
use Laramus\Liberius\Ancient\DBCon;

class Migration extends DBCon
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        $migrations = glob(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . '*.php');
        sort($migrations);

        foreach ($migrations as $migration) {
            try {
                $pathInfo = pathinfo($migration);
                $fileContent = file_get_contents($migration);

                require_once $migration;

                if (preg_match('/class\s+(\w+)/', $fileContent, $matches)) {
                    echo "Migrating " . $pathInfo['filename'] . "\n";

                    // get class name
                    $className = $matches[1];

                    $instance = new $className;
                    $instance->up($this->dbh); // run up method on class

                    echo "Migrate Success " . $pathInfo['filename'] . "\n";
                } else {
                    $className = '';
                    // echo "No class found \n";
                    exit;
                }

            } catch (\PDOException $e) {
                //throw $th;
                echo "Migrate Failed " . $e->getMessage() . "";
                exit;
            }
        }
    }

    public function down()
    {
        $migrations = glob(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . '*.php');
        sort($migrations);

        foreach ($migrations as $migration) {
            try {
                $pathInfo = pathinfo($migration);
                $fileContent = file_get_contents($migration);

                require_once $migration;

                if (preg_match('/class\s+(\w+)/', $fileContent, $matches)) {
                    echo "Deleting " . $pathInfo['filename'] . "\n";

                    // get class name
                    $className = $matches[1];

                    $instance = new $className;
                    $instance->down($this->dbh); // run up method on class

                    echo "Delete Success " . $pathInfo['filename'] . "\n";
                } else {
                    $className = '';
                    // echo "No class found \n";
                    exit;
                }
            } catch (\PDOException $e) {
                //throw $th;
                echo "Delete Failed " . $e->getMessage() . "";
                exit;
            }
        }
    }

    public function fresh()
    {
        $this->down();
        $this->up();
    }
}

$migration = new Migration;
if (isset($argv[1])) {
    $method = $argv[1];
    if ($method === "up" || $method === "down" || $method === "fresh") {
        $migration->$method();
    } else {
        echo "Usage : up|down|fresh";
        exit;
    }
} else {
    echo "Usage: php migration.php [up|down|fresh]\n";
}

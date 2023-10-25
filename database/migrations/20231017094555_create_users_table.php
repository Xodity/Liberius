<?php

class CreateUsersTable
{
    public function up($pdo)
    {
        $sql = "
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255),
                email VARCHAR(255),
                password VARCHAR(255)
            )
        ";
        $pdo->exec($sql);
    }

    public function down($pdo)
    {
        $sql = "
            DROP TABLE IF EXISTS users
        ";
        $pdo->exec($sql);
    }
}

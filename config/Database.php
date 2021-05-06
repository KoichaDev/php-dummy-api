<?php
class Database {
    // DB parameters
    private $db_host = 'localhost';
    private $db_name = 'myblog';
    private $db_username = 'root';
    private $db_password = '';
    private $connection;

    // DB Connect
    public function connect() {
        $this->connection = null;

        try {
            // Requires 3 parameter to connect the database
            $this->connection = new PDO(
                'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name,
                $this->db_username,
                $this->db_password
            );

            // PDO::ATTR_ERRMODE: Error reporting.
            // PDO::ERRMODE_EXCEPTION: Throw exceptions.
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $err) {
            echo 'Connection error ' . $err->getMessage();
        }

        return $this->connection;
    }
}

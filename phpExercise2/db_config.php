<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '123');
define('DB_DATABASE', 'hollow');

class DB_con {
    public $connection;
    function __construct(){
        $this->connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_DATABASE);
        if ($this->connection->connect_error) die('Database error -> ' . $this->connection->connect_error);
    }

    function retObj(){
        return $this->connection;
    }

    function closeDb() {
      mysqli_close($this->connection);
    }
}

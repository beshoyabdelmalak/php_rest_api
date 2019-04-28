<?php

class Database{
    private $host = "localhost";
    private $db = "myBlog";
    private $username = "root";
    private $pass = "root";
    private $connection;

    public function connect(){
        $this->connection = null;
        try {
            $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db, $this->username
            , $this->pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
        return $this->connection ;
    }
}
?>
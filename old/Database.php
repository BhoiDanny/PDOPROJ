<?php

class Database
{
    private $host = "localhost";
    private $dbUser = "root";
    private $dbPass = "";
    private $dbName = "pdoproj";

    private $db;
    private $error;
    private $stmt;

    public function __construct()
    {
        //Set DSN
        $dsn = "mysql:host=$this->host;dbname=$this->dbName";
        //Set Options
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

        );
        //Create New PDO
        try {
            $this->db = new PDO($dsn, $this->dbUser, $this->dbPass, $options);
        } catch (PDOException $e) {
            echo $this->error = $e->getMessage();
        }
    }

    public function query($query) {
        $this->stmt = $this->db->prepare($query);
    }

    public function bind($param, $value, $type = null) {
        if(is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param,$value,$type);
    }

    public function execute() {
        $this->stmt->execute();
    }

    public function lastInsertId() {
       return $this->db->lastInsertId();
    }

    public function resultSet() {
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
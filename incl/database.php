<?php

require_once("new_config.php");

class Database
{
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct($host, $username, $password, $dbname)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function createTable($table, array $columns = [])
    {
        // Create a sample table if it doesn't exist
        $sql = "CREATE TABLE IF NOT EXISTS $table ( id INT AUTO_INCREMENT PRIMARY KEY,";

        foreach($columns as $column_key => $column_value) {
            $sql .= $column_key . " " . $column_value . ',';
        }

        $sql = rtrim($sql, ',');
        $sql .= ')';
        
        if($this->conn->exec($sql)) {
            echo 'true';
            return true;
        } else {
            echo 'false';
            return false;
        }

    }

    public function createRecord($table, array $columns) 
    {
        // Insert a new user into the 'users' table
        if(!isset($table) && empty($columns)) {
            die("Provide records");
        }
        // setting the columns as string
        $column_keys = array_keys($columns);
        $string_columns = implode(",", $column_keys);
        $string_columns = rtrim($string_columns, ',');

        // setting it as a prepare string
        $prepare_values = array_keys($columns);
        $new_prepare_values = array_map( function($value) {
            return ":" . $value;
        }, $prepare_values);

        $prepare_values = implode(",", $new_prepare_values);
        $prepare_values = rtrim($prepare_values, ',');

        // Constructing the query
        $sql = "INSERT INTO $table($string_columns) VALUES ($prepare_values)";
        $stmt = $this->conn->prepare($sql);

        // Binding each value to the prepared parameter
        foreach($columns as $col => $val) {
            $stmt->bindValue(":".$col, $val);
        }

        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll($table)
    {
        // Retrieve all users from the 'users' table
        $stmt = $this->conn->query("SELECT * FROM $table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateRecor($table, $data) {
        if(!isset($table) && !isset($record)) {
            die("The method accepts two argument, table and record to update");
        }
        $sql = "UPDATE $table SET";
        foreach($data as $key => $value) {
            if($value == '') continue;
            $sql .= " $key = :$value,";
        }
        $sql = rtrim($sql, ',') . " WHERE id = ". $data['id'] ;
        echo $sql;
    }
    public function closeConnection()
    {
        // Close the database connection
        $this->conn = null;
    }

    public function getWhere($table, $condition) {
        $sql = "SELECT * FROM $table WHERE ";
        foreach($condition as $condition_key => $condition_value) {
           $sql .= ' ' . $condition_key . ' = '. "'$condition_value'" . ' AND' ; 
        }

        $sql = rtrim($sql, ' AND');

        $stmt = $this->conn->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Example usage
$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Create the 'users' table

?>

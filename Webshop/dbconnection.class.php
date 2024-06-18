<?php
// Define a class that extends the PDO class
class dbconnection extends PDO
{
    // Declare private properties for the host, database name, user, and password
    private $host;
    private $dbname;
    private $user;
    private $pass;

    // Define the constructor method
    public function __construct()
    {
        // Set the host, database name, user, and password
        $this->host = "localhost";
        $this->dbname = "graphicsland";
        $this->user = "root";
        $this->pass = "";

        // Call the parent constructor to create a new PDO instance
        parent::__construct("mysql:host=".$this->host.";dbname=".$this->dbname.";charset=utf8", $this->user, $this->pass);

        // Set the error mode to exception
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Turn off emulation of prepared statements
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
}
?>
<?php

// Define a class named dbconnection that extends the PDO class
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
        // If the hostname is 'LAPTOP-8MFERA24', use the local database credentials
        if(gethostname() == 'LAPTOP-8MFERA24'){
            $this->host = "localhost";
            $this->dbname = "graphicsland";
            $this->user = "root";
            $this->pass = "";

        // Otherwise, use the remote database credentials
        } else {
            $this->host = "localhost";
            $this->dbname = "u173298p199184_graphicsland";
            $this->user = "u173298p199184_graphicsland";
            $this->pass = "8H;Y\"?xqbhCzN0\"!5Z]ATOnucH";
        }

        // Call the parent constructor to create a new PDO instance
        parent::__construct("mysql:host=".$this->host.";dbname=".$this->dbname."; charset=utf8", $this->user, $this->pass);

        // Set the error mode to exception
        $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Turn off emulation of prepared statements
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
    }
}

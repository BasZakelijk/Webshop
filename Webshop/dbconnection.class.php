<?php

class dbconnection extends PDO
{
    private $host;
    private $dbname;
    private $user;
    private $pass;
    public function __construct()
    {
        if(gethostname() == 'LAPTOP-8MFERA24'){
            $this->host = "localhost";
            $this->dbname = "graphicsland";
            $this->user = "root";
            $this->pass = "";

        } else {
            $this->host = "localhost";
            $this->dbname = "";
            $this->user = "";
            $this->pass = "";
        }
        parent::__construct("mysql:host=".$this->host.";dbname=".$this->dbname."; charset=utf8", $this->user, $this->pass);
        $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
}

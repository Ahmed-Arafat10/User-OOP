<?php

class DB
{
    private const host = "localhost";
    private const username = "root";
    private const password = "";
    private const database = "users";
    public $Con;

    public function __construct()
    {
        $this->Con = new mysqli(self::host, self::username, self::password, self::database);
    }
    
    public function CheckDBCon()
    {
        if (!$this->Con->connect_errno) echo "Connected to Database";
        else $this->DBError();
    }
    
    public function DBError()
    {
        return "Falid to connect to MySQL " . $this->Con->connect_error;
    }

    public function Close()
    {
        $this->Con->close();
    }
}

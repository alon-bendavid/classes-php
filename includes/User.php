<?php
class User
{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    public $password;
    private $conn;


    public  function __construct($servername, $username, $password, $dbname)
    {

        $this->conn = new mysqli($this->$servername, $this->$username, $this->$password, $this->$dbname);

        return $this->conn;
    }
}

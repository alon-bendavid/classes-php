<?php
class User
{
    public $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    public $password;
    private $conn;

    // database connection
    public  function __construct($servername, $username, $password, $dbname)
    {

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        return $this->conn;
    }
    // set values to the properties
    public function setProperties($id, $login, $email, $firstname, $lastname, $password)
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
    }

    //register the acount into the database and print a tbale with the user details
    public function register()
    {
        $stmt = $this->conn->prepare("INSERT INTO utilisateurs (id, login, email, firstname, lastname, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $this->id, $this->login, $this->email, $this->firstname, $this->lastname, $this->password);
        $stmt->execute();
        return $stmt->affected_rows;
    }
    public function login($login, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE login = ? AND password = ?");
        $stmt->bind_param("ss", $login, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            // login successful
            session_start();
            $row = $result->fetch_assoc();
            $_SESSION["id"] = $row["id"];
            $_SESSION["login"] = $row["login"];
            return true;
        } else {
            // login failed
            return false;
        }
    }
    public function disconnect()
    {
        if (isset($_POST["disconnect"])) {
        }
    }
}

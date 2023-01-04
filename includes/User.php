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

    // database connection
    public  function __construct($servername, $username, $password, $dbname)
    {

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        return $this->conn;
    }
    //register the acount into the database and print a tbale with the user details
    public function register($id, $login, $password, $email, $firstname, $lastname)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO utilisateurs (id, login, password, email, firstname, lastname) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $id, $login, $password, $email, $firstname, $lastname);
        $stmt->execute();
    }
    public function connect($login, $password)
    {

        $stmt = $this->conn->prepare("SELECT password FROM utilisateurs WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                return true;
            }
        }
        return false;
    }
}

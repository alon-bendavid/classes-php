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
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO utilisateurs (id, login, email, firstname, lastname, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $this->id, $this->login, $this->email, $this->firstname, $this->lastname, $hashedPassword);
        $stmt->execute();
        return $stmt->affected_rows;
    }
    // login into the site
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
    // disconnect user
    public function disconnect()
    {
        session_unset();
        session_destroy();
    }
    // delete current user
    public function delete()
    {
        $stmt = $this->conn->prepare("DELETE FROM utilisateurs WHERE login = ?");
        $stmt->bind_param("i", $this->login);
        $stmt->execute();
        session_unset();
        session_destroy();
    }
    public function update($login, $password, $email, $firstname, $lastname)
    {
        $stmt = $this->conn->prepare("UPDATE utilisateurs SET login = ?, password = ?, email = ?, firstname = ?, lastname = ? WHERE login = ?");
        $stmt->bind_param("sssssi", $login, $password, $email, $firstname, $lastname, $this->login);
        $stmt->execute();
        return $stmt->affected_rows;
    }
    public function isConnected()
    {
        if (isset($_SESSION["login"])) {
            return true;
        } else {
            return false;
        }
    }
    public function getAllInfos()
    {
        echo "<table>";
        echo "<tr><th>ID</th><td>" . $this->id . "</td></tr>";
        echo "<tr><th>Login</th><td>" . $this->login . "</td></tr>";
        echo "<tr><th>Email</th><td>" . $this->email . "</td></tr>";
        echo "<tr><th>First Name</th><td>" . $this->firstname . "</td></tr>";
        echo "<tr><th>Last Name</th><td>" . $this->lastname . "</td></tr>";
        echo "</table>";
    }
}

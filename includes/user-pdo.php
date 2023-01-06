<?php
class Userpdo
{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    public $password;
    private $conn;


    // database connection----------------------------------------------------------------------------------------------------------------------------
    public  function __construct($id, $login, $email, $firstname, $lastname, $password)
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;

        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=classes", "root", "");
        } catch (PDOException $fail) {
            echo $fail->getMessage();
        }

        return $this->conn;
    }


    //register the acount into the database ----------------------------------------------------------------
    public function register($login, $email, $firstname, $lastname, $password)
    {
        // check if username already exist
        $stmt = $this->conn->prepare("SELECT id FROM utilisateurs WHERE login = ?");
        $stmt->bindValue(1, $login, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return "username already exist";
        }

        // Check for duplicate email
        $stmt = $this->conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->bindValue(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return "email already exist";
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $this->conn->prepare("INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES (?, ?, ?, ?, ?)");
        $stmt->bindValue(1, $login, PDO::PARAM_STR);
        $stmt->bindValue(2, $hashed_password, PDO::PARAM_STR);
        $stmt->bindValue(3, $email, PDO::PARAM_STR);
        $stmt->bindValue(4, $firstname, PDO::PARAM_STR);
        $stmt->bindValue(5, $lastname, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "username created";
        } else {
            return "error";
        }
    }



    //login user--------------------------------------------------------------------------------------------------------------------------
    public function login($login, $password)
    {
        $stmt = $this->conn->prepare("SELECT id, password FROM utilisateurs WHERE login = ?");
        $stmt->bindValue(1, $login, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->bindColumn(1, $id, PDO::PARAM_INT);
        $stmt->bindColumn(2, $hashed_password, PDO::PARAM_STR);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $this->id = $id;
            $_SESSION['user'] = $this->login;
            return true;
        } else {
            return false;
        }
    }


    // disconnect user---------------------------------------------------------------------------------------------------------------------
    public function disconnect()
    {
        session_unset();
        session_destroy();
    }

    // delete current user-----------------------------------------------------------------------------------------------------------------
    public function delete()
    {
        $stmt = $this->conn->prepare("DELETE FROM utilisateurs WHERE login = ?");
        $stmt->bindValue(1, $this->login, PDO::PARAM_STR);
        $stmt->execute();
        session_unset();
        session_destroy();
    }

    // update the user information-----------------------------------------------------------------------------------------------------------
    public function update($login, $password, $email, $firstname, $lastname)
    {
        $stmt = $this->conn->prepare("UPDATE utilisateurs SET login = ?, password = ?, email = ?, firstname = ?, lastname = ? WHERE login = ?");
        $stmt->bindValue(1, $login, PDO::PARAM_STR);
        $stmt->bindValue(2, $password, PDO::PARAM_STR);
        $stmt->bindValue(3, $email, PDO::PARAM_STR);
        $stmt->bindValue(4, $firstname, PDO::PARAM_STR);
        $stmt->bindValue(5, $lastname, PDO::PARAM_STR);
        $stmt->bindValue(6, $this->login, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    // check if user is connected------------------------------------------------------------------------------------------------------------
    public function isConnected()
    {
        if (isset($_SESSION["login"])) {
            return true;
        } else {
            return false;
        }
    }
    // fetch user info and present it as a table--------------------------------------------------------------------------------------------------
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
    //return specific user information--------------------------------------------------------------------------------------------------------
    // username--------------------------
    public function getLogin()
    {
        return $this->login;
    }
    // email-----------------------------
    public function getEmail()
    {
        return $this->email;
    }
    // first name------------------------
    public function getFirstname()
    {
        return $this->firstname;
    }
    // last name-------------------------
    public function getLastname()
    {
        return $this->lastname;
    }
}
// $user = new Userpdo(null, "pdo test", "pdo@gmail.com", "pdo", "newpdo", "1234");
// $user->register("pdo test", "pdo@gmail.com", "pdo", "newpdo", "1234");

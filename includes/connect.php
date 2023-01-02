<?php
//conect into database in plesk
// $con = mysqli_connect("localhost", "reserveMeToday50", "laplateforme", "ben-david-alon_reservationsalles");
// if (!$con = mysqli_connect("localhost", "reserveMeToday50", "laplateforme", "ben-david-alon_reservationsalles")) {
//     die("failed to connect!");
// }


//connect to database in development
// $con = mysqli_connect("localhost", "root", "", "classes");

// if (!$con = mysqli_connect("localhost", "root", "", "classes")) {
//     die("failed to connect!");
// }

class database
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    protected function connect()
    {
        $this->servername = "localhost";
        $this->username = "localhost";
        $this->password = "localhost";
        $this->dbname = "localhost";
    }
}

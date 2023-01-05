<?php
require("../includes/User.php");
$id = null;
$login = "bbbb";
$email = "bbb@test.com";
$firstname =  "bbb";
$lastname = "reqsdgister";
$password = "1234";


$user = new User(null, $login, $email, $firstname, $lastname, $password);
// $user->setProperties(null, "user2", "user2@example.com", "roling", "flozs", "password2");
$result = $user->register($login, $email, $firstname, $lastname, $password);
$user->getAllInfos();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    ?>

</body>

</html>
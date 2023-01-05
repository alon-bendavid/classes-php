<?php
require("../includes/User.php");

$user = new User(null, "newuser", "newuser@example.com", "blop", "shlop", "password5");
// $user->setProperties(null, "user2", "user2@example.com", "roling", "flozs", "password2");
$result = $user->register();
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
<?php
require("../includes/User.php");

$user = new User("localhost", "root", "", "classes");
$user->register(NULL, "user1", "password1", "user1@example.com", "John", "Doe");

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
    foreach ($details as $x) {
        echo $x;
    }
    ?>

</body>

</html>
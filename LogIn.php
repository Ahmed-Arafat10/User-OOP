<?php
require_once("Class/User.class.php");
require_once("Functions.php");

if(IsLoggedIn())
{
    echo "already logged in";
    exit;
}

if (isset($_POST['submitBTN'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $user = new User();
    $Check = $user->LogIn($name, $password);
    if ($Check) {
        $_SESSION["UserData"] = $user->GetUserData();
        echo "Go to your" . "<a href = 'Profile.php'>Profile</a>";
    } else {
        echo "Not exists";
    }
}


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
    <form method="POST" action="LogIn.php" enctype="multipart/form-data">
        <label for="">Name</label>
        <input type="text" name="name">
        <br>
        <label for="">Password</label>
        <input type="password" name="password">
        <input type="submit" value="signup" name="submitBTN">
    </form>
</body>

</html>
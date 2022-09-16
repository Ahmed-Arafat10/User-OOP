<?php
session_start();
require_once("Functions.php");

if(!IsLoggedIn())
{
    echo "sign in first";
    exit;
}


echo "<pre>";
//print_r($_SESSION["userdata"]);
$Data = $_SESSION["UserData"];
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
    <img src="uploads/<?php echo $Data['Pic'] ?>" alt="">
    <p><?php echo $Data['Name'] ?></p>
    <p><?php echo $Data['Email'] ?></p>
    <a href="LogOut.php">LogOut</a>
    <a href="EditProfile.php?ID=<?php echo $Data['ID']?>">Edit</a>
</body>
</html>
<?php
require_once("Class/User.class.php");
require_once("Functions.php");

if (!IsLoggedIn()) {
    echo "Sign In First";
    exit;
}

$Data = $_SESSION["UserData"];

if (isset($_POST['submitBTN'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $pic = array();
    $pic[] = $_FILES['pic']['name'];
    $pic[] = $_FILES['pic']['tmp_name'];
    $pic[] = $_FILES['pic']['type'];
    $user = new User();
    $is = $user->EditAccount($Data['ID'], $name, $email, $password, $gender, $pic);
    if ($is) {
        $_SESSION["UserData"] = $user->GetDataFromDB($Data['ID']);
    } else {
        echo "Something went wrong";
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
    <form method="POST" action="EditProfile.php" enctype="multipart/form-data">
        <label for="">Name</label>
        <input type="text" name="name" value="<?php echo $Data['Name'] ?>">
        <br>
        <label for="">Email</label>
        <input type="email" name="email" value="<?php echo $Data['Email'] ?>">
        <br>
        <label for="">Password</label>
        <input type="password" name="password" value="<?php echo $Data['Password'] ?>">
        <br>
        Male<input type="radio" value="0" name="gender">
        Female <input type="radio" value="1" name="gender">
        <br>
        <input type="file" name="pic">
        <br>
        <input type="submit" value="signup" name="submitBTN">
    </form>
</body>

</html>
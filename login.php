<?php
require "load.php";
if (isset($_POST["uname"], $_POST["pass"], $_POST["submit"])) {
    $uname =trim( $_POST["uname"]);
    $password =trim( $_POST["pass"]);
    $sql = "SELECT `id` FROM `user` WHERE `username`=:username AND `password`=:password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":username", $uname);
    $stmt->bindParam(":password", $password);
    $stmt->execute();
    $user = $stmt->fetch();
    //var_dump($s);
    if($user===false){
        $error="مشخصات وارد شده صحیح نیست";
        echo $error;
    }else{
        $_SESSION["user_id"]=$user["id"];
        redirect("panel.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        form {
            text-align: center;
        }
    </style>

</head>
<body>
<form action="" method="post">
    <input type="text" name="uname" placeholder="name"><br>
    <input type="password" name="pass" placeholder="passeord"> <br>
    <input type="submit" name="submit" value="send"><br>
</form>
</body>
</html>


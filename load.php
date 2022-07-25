<?php
session_start();
require "secret.php";
try {
    $conn = new PDO("mysql:host=localhost;dbname=time_site", "root", "");
    $conn->exec("SET NAMES utf8");
    //echo "اتصال موفق بود";
} catch (PDOException $e) {
    echo "اتصال موفق نبود" . $e->getMessage();
    exit();
}
#functions
function redirect($path)
{
    header("Location:" . $path);
    exit();
}

function auth_require()
{
    if (!isset($_SESSION["user_id"])) {
        redirect("login.php");
    }
}

function get_project()
{

    global $conn;
    $sql = "SELECT * FROM `project` ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $projects;
}

function chek_project($id)
{
    global $conn;
    $sql = "SELECT `code` FROM `project` WHERE `code`=?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $chek = $stmt->fetchColumn();
    if ($chek > 0) {
        return true;
    } else {
        return false;
    }
}

function chek_product($id)
{
    global $conn;
    $sql = "SELECT `code` FROM `product` WHERE `code`=?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1,$id);
    $stmt->execute();
    $chek = $stmt->fetchColumn();
    if ($chek > 0) {
        return true;
    } else {
        return false;
    }
}

function get_product($project_id)
{
    global $conn;
    $sql = "SELECT * FROM `product` WHERE `project_id`= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $project_id);
    $stmt->execute();
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $product;
}

/*function getuserid( int $userid) : array
{

    $sql = "SELECT * FROM `user` WHERE `id`=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id",$_SESSION["user_id"]);
    $stmt->execute();
    $user = $stmt->fetch();
    return $user;
}*/
########


if (isset($_SESSION["user_id"])) {
    $sql = "SELECT * FROM `user` WHERE `id`=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_SESSION["user_id"]);
    $stmt->execute();
    $user = $stmt->fetch();
    $_SESSION["user"] = $user;
    if ($user === false) {
        // $user=getuserid($_SESSION["user_id"]);
        unset($_SESSION["user_id"]);
        redirect("login.php");
    }
//echo $user["first_name"];
}
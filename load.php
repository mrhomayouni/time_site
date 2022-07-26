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
    $stmt->bindParam(1, $id);
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

function get_product0($id)
{
    global $conn;
    $sql = "SELECT * FROM `product` WHERE `code`= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    return $product;
}

function get_product_get_project_name($product_id)
{
    global $conn;
    $sql1 = "SELECT * FROM `product` WHERE `code`=:product_code";
    $stmt = $conn->prepare($sql1);
    $stmt->bindParam(":product_code", $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $product["name"] . " " . $product["code"];
    echo "<br>";
    $a = $product["project_id"];
    $sql2 = "SELECT * FROM `project` WHERE `code`=?";
    $stmt1 = $conn->prepare($sql2);
    $stmt1->bindParam(1, $a);
    $stmt1->execute();
    $project = $stmt1->fetch(PDO::FETCH_ASSOC);
    echo $project["name"] . " " . $project["code"];
}

function get_activitys()
{
    global $conn;
    $sql = "SELECT * FROM `activity` ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $activitis = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $activitis;
}

function report($user_id,$project_id,$product_id,$activity_id,$normal_h,$normal_m,$extra_h,$extra_m,$created_at,$time)
{
    global $conn;
    $sql = "INSERT INTO `report`( `user_id`, `project_id`, `product_id`, `activity_id`, `normal_h`, `normal_m`, `extra_h`, `extra_m`, `created_at`, `time`)
 VALUES (?,?,?,?,?,?,?,?,?,?)";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(1,$user_id);
    $stmt->bindParam(2,$project_id);
    $stmt->bindParam(3,$product_id);
    $stmt->bindParam(4,$activity_id);
    $stmt->bindParam(5,$normal_h);
    $stmt->bindParam(6,$normal_m);
    $stmt->bindParam(7,$extra_h);
    $stmt->bindParam(8,$extra_m);
    $stmt->bindParam(9,$created_at);
    $stmt->bindParam(10,$time);
    $stmt->execute();
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

################


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
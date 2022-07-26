<?php
require "load.php";

$chekproduct=chek_product($_GET["produtce"]);
//var_dump($chekproduct);
/*if($chekproduct==false){
    redirect("panel.php");
}*/
global $user;
echo $user["first_name"].$user["last_name"]."<br>";
$produt_id=$_GET["produtce"];
$product=get_product0($produt_id);
$project_id=$product["project_id"];
get_product_get_project_name($_GET["produtce"]);
$activitis=get_activitys();
    if (isset($_POST["sub"])){
    echo "<br>";
    $names=$_POST["name"];
    foreach ($names as $key=>$valu){
        $a=$valu["normal"];
        $a=explode(":",$a);
        $normal_h=(int)$a[0];
        $normal_m=(int)$a[1];
        $b=$valu["extra"];
        $b=explode(":",$b);
        $extra_h=(int)$b[0];
        $extra_m=(int)$b[1];
        $time=time();
        
        report($user["id"],"$project_id","$produt_id","$key","$normal_h","$normal_m","$extra_m","$extra_m","$time","$time");


    }
}
?>

<form action="" method="post" >
    <?php foreach ($activitis as $activiti) {?>
        <span style="padding-left: 150px" > <?= $activiti["name"] ?></span><br>
        <input type="text" name=" name[<?= $activiti["id"]?>][extra]" placeholder="زمان اضافی">   <input type="text" name="name[<?= $activiti["id"]?>][normal]" placeholder="زمان عادی">
        <br><br>

    <?php }?>
    <span style="padding-left: 150px"> <input type="submit" value="send" name="sub"></span>
</form>

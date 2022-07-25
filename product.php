<?php
require "load.php";
$chekproduct=chek_product($_GET["produtce"]);
//var_dump($chekproduct);
if($chekproduct==false){
    redirect("panel.php");
}else{
    echo "aaaa";
    var_dump($chekproduct);
}
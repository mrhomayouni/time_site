<?php
require "load.php";
auth_require();
$projects = get_project();
if (isset($_GET["sendproject"])) {
    $chekproject = chek_project($_GET["project"]);
    $products = get_product($_GET["project"]);
}

?>
<b><a href="logout.php">خروج</a></b>
<br>
<b><?= $user["first_name"] . " " . $user["last_name"] ?> </b>
<form action="" method="get">
    <b> نام پروژه</b>
    <select name="project">
        <?php foreach ($projects as $projects_item) { ?>
            <option value="<?php echo $projects_item ["code"] ?>"><?= $projects_item['name'] . $projects_item['code']; ?></option>
        <?php } ?>
    </select>
    <input type="submit" value="send" name="sendproject">
</form>
<?php if (isset($_GET["sendproject"]) && $chekproject) {
    ?>
    <form action="product.php" method="get">
        <b> نام محصول</b>
        <select name="produtce">
            <?php ?>
            <?php foreach ($products as $product) { ?>
                <option value="<?php echo $product ["code"] ?>"><?= $product['name'] . $product['code']; ?></option>
            <?php } ?>
        </select>
        <input type="submit" value="send" name="send">

    </form>
<?php } ?>


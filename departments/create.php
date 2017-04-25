<?php
require_once('../App.php');
$sql = $app->request("SELECT * FROM departments");

if(isset($_POST['name'])) {
    $sql = "INSERT INTO departments (name) VALUES ('" . $_POST['name'] . "')";
    $result = $app->request($sql);
    if ($result) {
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/departments.php");
    }
}

require_once('../header.php'); ?>

<form action='<?=$_SERVER['PHP_SELF']?>' method='post'>
    <p class="departments__create-p"><input type = "text" name ="name" /> </p>
    <p class="departments__create-p"><input type="submit" /></p>
</form>

<?php require_once('../footer.php'); ?>
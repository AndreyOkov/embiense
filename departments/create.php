<?php
require_once ('../App.php');
$sql = $app->request("SELECT * FROM departments");

if(isset($_POST['name'])) {
    $sql = "INSERT INTO departments (name, count, max_salary)" .
        " VALUES ('" . $_POST['name'] . "', "
        . (integer)$_POST['count'] . ", "
        . (integer)$_POST['maxsalary']  .
        ")";
    $result = $app->request($sql);
    if ($result) {
        header("Location: http://job"  . "/departments.php");
    }
}
    
require_once ('../header.php'); ?>

<form action='<?=$_SERVER['PHP_SELF']?>' method='post'>
    <p class="departments__create-p"><input type = "text" name ="name" /> </p>
    <p class="departments__create-p"><input type = "text" name ="count" /> </p>
    <p class="departments__create-p"><input type = "text" name ="maxsalary" /> </p>
    <p class="departments__create-p"><input type="submit" /></p>
</form>

<?php require_once ('../footer.php'); ?>
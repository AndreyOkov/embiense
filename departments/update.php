<?php
use application\App;
require_once ('../App.php');

if (isset($_POST['name'])) {

    $sql = "UPDATE  departments SET " .
        " name = '" . $_POST['name'] .
        "' WHERE id=" . (integer)$_POST['id'];
    $result = $app->request($sql);
    if ($result) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/departments.php");
    }
}

require_once ('../header.php');

$sql = "SELECT * FROM departments WHERE id=" .(integer) $_GET['id'];
$result = $app->request($sql);

////////////////// Обновление отдела /////////////////
if($res = mysqli_fetch_array($result, MYSQLI_BOTH)) { ?>
    <form action="<?=$_SERVER['PHP_SELF']?>" method='post'>
    <p><label for="name">Название отдела:</label> <input type = "text" name ="name" value ="<?= $res['name']?>" /> </p>
    <p><input type = "hidden" name ="id" value="<?= $_GET['id']?> " /> </p>
    <p><input type="submit"  value="Обновить"/></p>
    </form>
<?php } require_once ('../footer.php');?>

<?php

require_once('../App.php');

$sql = "DELETE  FROM departments WHERE id=" .(integer) $_GET['id'];
$result = $app->request($sql);

if ($result) {
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/departments.php");
}

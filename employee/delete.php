<?php require_once ('../App.php');


$sql = "DELETE  FROM employee WHERE id=" .(integer) $_GET['id'];
$result = $app->request( $sql );

if( $result )
{
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/employee.php");
}
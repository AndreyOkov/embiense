<?php
require('functions.php');
$mysqli = new mysqli('localhost', 'root', '');
$mysqli->select_db('Job');
$mysqli->set_charset('utf8');

$_POST = $_POST['formData'];

$id = $_POST['id'];
$valid = true;
if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['departments'])) {
    $mysqli->query("DELETE  FROM employee_department WHERE id_employee =$id");

    $sql = "UPDATE  employee 
                    SET  firstname = ?, lastname = ?, patronymic = ?, gender = ?, salary = ? WHERE id= ?";

    $result = $mysqli->prepare($sql);
    $result->bind_param('ssssii',
        $_POST['firstname'],
        $_POST['lastname'],
        $_POST['patronymic'],
        $_POST['gender'],
        $_POST['salary'],
        $id);

    addDepartmentsToEmployee($id, $mysqli);
    if (!$result->execute()) {
        $valid = false;
    }
}
echo json_encode([$valid]);

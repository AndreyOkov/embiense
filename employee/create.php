<?php

require_once('../App.php');
require_once('../functions.php');

define('ACTION', $_GET['action']);


if ($_POST['action'] == 'create') {
    if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['departments'])) {
        $sql = "INSERT INTO employee (firstname, lastname, patronymic, gender, salary)" .
            " VALUES ('" . $_POST['firstname'] . "','"
            . $_POST['lastname'] . "','"
            . $_POST['patronymic'] . "','"
            . $_POST['gender'] . "',"
            . (integer)$_POST['salary'] . ")";
        $app->request($sql);

        addDepartmentsToEmployee(mysqli_insert_id($app->getDb()), $app);
    } else {
        $error = 'Не заполнены обязательные поля...';
    }
}
if ($_POST['action'] == 'update') {
    if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['departments'])) {
        $sql = "DELETE  FROM employee_department WHERE id_employee =" . (integer)$_POST['id'];
        $result = $app->request($sql);

        $sql = "UPDATE  employee " .
            "SET  firstname = '" . $_POST['firstname'] . "', " .
            "lastname = '" . $_POST['lastname'] . "', " .
            "patronymic = '" . $_POST['patronymic'] . "', " .
            "gender = '" . $_POST['gender'] . "', " .
            "salary = " . $_POST['salary'] . " WHERE id=" . (integer)$_POST['id'];
        $app->request($sql);

        addDepartmentsToEmployee($_POST['id'], $app);
    } else {
        $error = 'Не заполнены обязательные поля...';
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $sql = "DELETE  FROM employee WHERE id=" . (integer)$_GET['id'];
    $result = $app->request($sql);
    if ($result) {
        header("Location: /employee.php");
    }
}

include('./_form.php');
require_once('../footer.php');

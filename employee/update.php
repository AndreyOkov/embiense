<?php
require_once('../App.php');

if (!empty($_POST)) {
    if (isset($_POST['firstname']) && isset($_POST['lastname'])) {
        $sql = "DELETE  FROM employee_department WHERE id_employee =" . (integer)$_POST['id'];
        $result = $app->request($sql);

        $sql = "UPDATE  employee" .
            " SET  firstname = '" . $_POST['firstname'] . "', " .
            "lastname = '" . $_POST['lastname'] . "', " .
            "patronymic = '" . $_POST['patronymic'] . "', " .
            "gender = '" . $_POST['gender'] . "', " .
            "salary = " . $_POST['salary'] . " WHERE id=" . (integer)$_POST['id'];
        $result = $app->request($sql);

        if ($result) {
            if (isset($_POST['departments'])) {
                foreach ($_POST['departments'] as $department) {
                    $sql = "INSERT INTO employee_department VALUES (" .
                        (integer)$_POST['id'] . ", " . (integer)$department . ")";
                    $result = $app->request($sql);
                    if ($result) {
                        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/employee.php");
                    }
                }
            } else {
                die("Не выбран отдел");
            }
        } else {
            die("Данные не обновлены");
        }
    } else {
        die('Не введено имя или фамилия');
    }
}

require_once('../header.php');
require_once('../functions.php');

$employeeDepartments = [];
$allDepartments = [];

$sql = "SELECT e.*, dp.id AS department_id, dp.name AS department_name
FROM departments dp
LEFT JOIN (
SELECT * 
FROM employee_department ed
LEFT JOIN employee em
ON ed.id_employee = em.id
WHERE em.id =" . (integer)$_GET['id'] . ") AS e
ON dp.id = e.id_department";

$result1 = $app->request($sql);

while ($row = mysqli_fetch_assoc($result1)) {
    if (!isset($resultForm)) {
        if (!empty($row['firstname'])) {
            $resultForm = $row;
        }
    }
    if (!empty($row['firstname'])) {
        array_push($employeeDepartments, $row['department_name']);
    }
    $allDepartments[$row['department_id']] = $row['department_name'];
}
include('./_form.php') ?>


<? require_once('../footer.php'); ?>

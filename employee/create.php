<?php
require_once('../App.php');
if (isset($_POST['firstname'])) {
    $sql = "INSERT INTO employee (firstname, lastname, patronymic, gender, salary)" .
        " VALUES ('" . $_POST['firstname'] . "','"
        . $_POST['lastname'] . "','"
        . $_POST['patronymic'] . "','"
        . $_POST['gender'] . "',"
        . (integer)$_POST['salary'] . ")";

    $result = $app->request($sql);

    if ($result) {
        $sql = "SELECT id FROM employee ORDER BY id DESC LIMIT 1";

        $newemployee = $app->request($sql);

        if ($newemployee) {
            $id = mysqli_fetch_assoc($newemployee);

            if (isset($_POST['departments'])) {
                foreach ($_POST['departments'] as $res) {
                    $sql = "INSERT INTO employee_department
                                VALUES (" . $id['id'] . ", " . (integer)$res . ")";

                    $result = $app->request($sql);
                    if ($result) {
                        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/employee.php");
                    }
                    }
                }
            }
        }
    }

require_once('../header.php');
require_once('../functions.php');

$sql = "SELECT id AS department_id, name AS department_name  FROM departments";

// Создание сотрудника ...
$employeeDepartments = [];
$result = $app->request($sql);

while ($row = mysqli_fetch_assoc($result)) {
    if (!isset($formData)) {
        if (!empty($row['firstname'])) {
            $formData = $row;
        }
    }
    if (!empty($row['firstname'])) {
        array_push($employeeDepartments, $row['department_name']);
    }
    $allDepartments[$row['department_id']] = $row['department_name'];
}
// Вывод формы...
include('./_form.php');

require_once('../footer.php');

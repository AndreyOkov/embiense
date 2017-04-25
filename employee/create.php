<?php

require_once('../App.php');

define('ACTION', $_GET['action']);


if (isset($_POST['firstname'])) {
    if ($_POST['action'] == 'create') {
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
    if ($_POST['action'] == 'update') {
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
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $sql = "DELETE  FROM employee WHERE id=" . (integer)$_GET['id'];
    $result = $app->request($sql);
    if ($result) {
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/employee.php");
    }
}

include('./_form.php');
require_once('../footer.php');

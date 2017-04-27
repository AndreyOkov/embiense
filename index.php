<?php

require('functions.php');
require('queries.php');
$mysqli = new mysqli('localhost', 'root', '');
$mysqli->select_db('Job');
$mysqli->set_charset('utf8');

$action = isset($_GET['act']) ? $_GET['act'] : 'index';

ob_start();
switch ($action) {
    case 'index':
        $rows = $mysqli->query($sqls['index']);
        $departments = [];
        $employees = [];
        foreach ($rows as $row) {
            if (!isset($departments[$row['department_id']])) {
                $departments[$row['department_id']] = $row['department_name'];
            }
            if (!isset($employees[$row['id']]) && isset($row['id'])) {
                $employees[$row['id']] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'departments' => []
                ];
            }
            if (!empty($row['name'])) {
                array_push($employees[$row['id']]['departments'], $row['department_id']);
            }
        }
        require("./views/index.php");
        break;
    case 'employees':
        $result = $mysqli->query($sqls['employees']);
        require('./views/employees.php');
        break;
    case 'departments':
        $res = $mysqli->query($sqls['departments']);
        require('./views/departments.php');
        break;
    case 'dep-update':
        $id = $_GET['id'];
        $formData = $mysqli->query("SELECT * FROM departments WHERE id = $id")->fetch_assoc();
        $type = 'update';
        require("./views/dep-update.php");
        break;
    case 'apply-dep-update':
        $id = intval($_POST['id']);
        $sql = $mysqli->prepare("UPDATE departments SET name = ? WHERE id = ?");
        $sql->bind_param('si', $_POST['name'], $id);

        if ($sql->execute()) {
            header('Location: ?act=departments');
        } else {
            die("Cannot insert entry");
        }
        break;
    case 'dep-create':
        $type = 'create';
        require("./views/dep-update.php");
        break;

    case 'apply-dep-create':
        $sql = $mysqli->prepare("INSERT INTO departments(name) VALUES(?)");
        $sql->bind_param('s', $_POST['name']);
        if ($sql->execute()) {
            header('Location: ?act=departments');
        } else {
            die('Cannot insert entry');
        }
        break;
    case 'dep-delete':
        $id = $_GET['id'];
        $formData = $mysqli->query("DELETE  FROM departments WHERE id = $id")
        or die("Cannot delete department");
        header('Location: ?act=departments');
        break;
    case 'emp-update':
        $type = 'update';
        $id = $_GET['id'];
        $sql = "SELECT 
                      e.*, 
                      dp.id AS department_id, 
                      dp.name AS department_name
                FROM departments dp
                LEFT JOIN (
                      SELECT 
                            *
                      FROM 
                            employee_department ed
                      LEFT JOIN employee em     ON ed.id_employee = em.id
                      WHERE em.id =$id) AS e
                ON dp.id = e.id_department";

        require('./views/emp-update.php');
        break;
    case 'apply-emp-update':
        $id = $_POST['id'];
        if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['departments'])) {
            $mysqli->query("DELETE  FROM employee_department WHERE id_employee =$id") or die('cannot delete entries');

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
            if ($result->execute()) {
                header('Location: ?act=employees');
            } else {
                die('cannot update entry');
            }
        }
        break;
    case 'emp-create':
        $type = 'create';
        $sql = "SELECT id AS department_id, name AS department_name  FROM departments";
        require('./views/emp-update.php');

        break;
    case 'apply-emp-create':
        if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['departments'])) {
            $sql = $mysqli->prepare("INSERT INTO  employee(firstname, lastname, patronymic, gender, salary) 
                                   VALUES (?,?,?,?,?)");

            $sql->bind_param('ssssi',
                $_POST['firstname'],
                $_POST['lastname'],
                $_POST['patronymic'],
                $_POST['gender'],
                $_POST['salary']);

            if ($sql->execute() && addDepartmentsToEmployee(mysqli_insert_id($mysqli), $mysqli)) {
                header('Location: ?act=employees');
            } else {
                die('cannot update entry');
            }
        } else {
            $error = 'Не заполнены обязательные поля...';
        }
        break;
    case 'emp-delete':
        $id = $_GET['id'];
        $mysqli->query("DELETE  FROM employee WHERE id = $id")
        or die("Cannot delete department");
        header('Location: ?act=employees');
        break;
    case 'apply-dep-update':
        $id = intval($_POST['id']);
        $sql = $mysqli->prepare("UPDATE departments SET name = ? WHERE id = ?");
        $sql->bind_param('si', $_POST['name'], $id);

        if ($sql->execute()) {
            header('Location: ?act=departments');
        } else {
            die("Cannot insert entry");
        }
        break;
    default:
        die('No such action');
}

$content = ob_get_contents();
ob_get_clean();
?>

<?php require('./template.php'); ?>






<?php

require_once('../header.php');
$sql = '';

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'create':
            $sql = "SELECT id AS department_id, name AS department_name  FROM departments";
            $params = '?action=create';
            break;
        case 'update':
            $sql = "SELECT e.*, dp.id AS department_id, dp.name AS department_name
                    FROM departments dp
                    LEFT JOIN (
                    SELECT *
                    FROM employee_department ed
                    LEFT JOIN employee em
                    ON ed.id_employee = em.id
                    WHERE em.id =" . (integer)$_GET['id'] . ") AS e
                    ON dp.id = e.id_department";
            $params = '?id=' . $_GET['id'] . '&action=update';

            break;
    }
}


// Создание сотрудника ...
$allDepartments = [];
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
if ($error) {
    echo $error;
}
?>


<form action="<?= $_SERVER['PHP_SELF'] . $params ?: '' ?>" method='post'>
    <p><label for="firstname">Фамилия:</label>
        <input type="text" name="firstname" value="<?= field($formData, 'firstname') ?>"/></p>
    <p><label for="lastname">Имя:</label>
        <input type="text" name="lastname" value="<?= field($formData, 'lastname') ?>"/></p>
    <p><label for="patronymic">Отчество:</label>
        <input type="text" name="patronymic" value="<?= field($formData, 'patronymic') ?>"/></p>
    <p><label for="gender">Пол:</label>
        <input type="text" name="gender" value="<?= field($formData, 'gender') ?>"/></p>
    <p><label for="salary">З/п:</label>
        <input type="text" name="salary" value="<?= field($formData, 'salary') ?>"/></p>
    <p><input type="hidden" name="id" value="<?= field($formData, 'id') ?>"/></p>
    <p><input type="hidden" name="action" value="<?= ACTION ?>"/></p>

    <p><label>Отделы:</label>
        <select class="chosen" multiple="true" name="departments[]">
            <?php optionHelper($allDepartments, $employeeDepartments); ?>
        </select>
    <p><input type="submit"/></p>
</form>

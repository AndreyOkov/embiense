<?php

use application\App;

require_once('header.php');
require_once('App.php');
?>

<?php
$sql = 'SELECT e . id, 
            CONCAT_WS(" ", e.firstname, e.lastname, e.patronymic) AS name,
            d.id AS department_id, d.name AS department_name
            FROM  departments d 
            LEFT JOIN employee_department ed
              ON d.id = ed.id_department
            LEFT JOIN employee e
              ON e.id = ed.id_employee
            ORDER BY e.id';

$rows = $app->request($sql);


$departments = [];
$employees = [];
var_dump($rows);
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
} ?>

<table>
    <tr>
        <th></th>
        <?php foreach ($departments as $department_name) { ?>
            <th><?php echo $department_name; ?></th>
        <?php } ?>
    </tr>
    <?php foreach ($employees as $employee) { ?>
        <tr>
            <th><?php echo $employee['name']; ?></th>
            <?php foreach ($departments as $department_id => $department_name) { ?>
                <td class="index__table-td">
                    <?php echo(in_array($department_id, $employee['departments']) ? '+' : '-'); ?>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>

<?php require_once('footer.php'); ?>

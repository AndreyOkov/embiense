<?php

defined('ROOT') or define('ROOT', dirname(__FILE__));

require_once('header.php');
require_once('App.php');

?>

    <p class='title-p'>Сотрудники</p>
    <table border='1'>

        <?php
        $sql = "
    SELECT DISTINCT em.id AS em_id, CONCAT_WS(' ', em.firstname, em.lastname, em.patronymic) AS fio,
     em.gender, em.salary, (SELECT GROUP_CONCAT( dp.name ) AS deps
    FROM employee em
    JOIN employee_department emdp
      ON em.id = emdp.id_employee
    JOIN departments dp
      ON emdp.id_department = dp.id  WHERE  em.id = em_id) AS departments
    FROM employee em";

        $result = $app->request($sql); ?>
<tr>
<td>ФИО</td>
<td>Пол</td>
<td>З/п</td>
<td>Отдел</td>
<td></td>
<td></td></tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['fio'] ?></td>
        <td><?= $row['gender'] ?></td>
        <td><?= $row['salary'] ?></td>
        <td width="300"><?= $row['departments'] ?></td>
        <td><a href="/employee/create.php?id=<?= $row['em_id'] ?>&action=update">UPDATE</a>
        <td><a href="/employee/create.php?id=<?= $row['em_id'] ?>&action=delete">DELETE</a>
    </tr>

<?php } ?>

</table>
    <a class='action' href='./employee/create.php?action=create'>СОЗДАТЬ</a>

<?php require_once('./footer.php'); ?>
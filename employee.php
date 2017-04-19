<?php
require_once('header.php');
require_once('App.php');

echo "<p class='title-p'>Сотрудники</p>";
echo "<table border='1'>";

$sqlin = "
    SELECT DISTINCT em.id AS em_id, CONCAT_WS(' ', em.firstname, em.lastname, em.patronymic) AS fio,
     em.gender, em.salary, (SELECT GROUP_CONCAT( dp.name ) AS deps
    FROM employee em
    JOIN employee_department emdp
      ON em.id = emdp.id_employee
    JOIN departments dp
      ON emdp.id_department = dp.id  WHERE  em.id = em_id) AS ddd
      
    FROM employee em
    JOIN employee_department emdp
      ON em.id = emdp.id_employee
    JOIN departments dp
      ON emdp.id_department = dp.id";

$sql = $app->request($sqlin); ?>

<tr>
<td>ФИО</td>
<td>Пол</td>
<td>З/п</td>
<td>Отдел</td>
<td></td>
<td></td></tr>
<?php  while($res = mysqli_fetch_row($sql)){ $arr = []; ?>

    <tr>
        <td><?= $res[1] ?></td>
        <td><?= $res[2] ?></td>
        <td><?= $res[3] ?></td>
        <td width="300"><?= $res[4] ?></td>
    <td><a href="/employee/update.php?id=<?=$res[0]?>">UPDATE</a>
    <td><a href="/employee/delete.php?id=<?=$res[0]?>">DELETE</a>
    </tr>

<?php } ?>

</table>
    <a class='action' href='./employee/create.php'>СОЗДАТЬ</a>

<?php require_once('./footer.php'); ?>
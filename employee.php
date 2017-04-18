<?php
require_once('header.php');
require_once('App.php');

echo "<p class='title-p'>Сотрудники</p>";

echo "<table border='1'>";

$sql = $app->request("SELECT * FROM employee"); ?>

<tr>
<td>ФИО</td>

<td>Пол</td>
<td>З/п</td>
<td>Отдел</td>
<td></td>
<td></td></tr>
<?php  while($res = mysqli_fetch_row($sql)){ $arr = []; ?>

    <tr>
    <td><?=$res[1]. ' ' . $res[2] . ' ' . $res[3]?></td>
    <td><?=$res[4]?></td>
    <td><?=$res[5]?></td>


<?php
    $sqlin = "
    SELECT dp.name FROM employee em
    JOIN employee_department emdp
      ON em.id = emdp.id_employee
    JOIN departments dp
      ON emdp.id_department = dp.id
      WHERE em.id = " . (integer)$res[0];

    $sqres = $app->request($sqlin);

    while($result1 = mysqli_fetch_row($sqres)){
        $arr[] = $result1[0];
    } ?>
    <td width="300"><?=implode(', ', $arr)?></td>

    <td><a href="/employee/update.php?id=<?=$res[0]?>">UPDATE</a>
    <td><a href="/employee/delete.php?id=<?=$res[0]?>">DELETE</a>
    </tr>

<?php } ?>

</table>
    <a class='action' href='./employee/create.php'>СОЗДАТЬ</a>

<?php require_once('./footer.php'); ?>
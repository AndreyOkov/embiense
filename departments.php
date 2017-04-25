<?php  require_once('./header.php'); ?>
<?php  require_once('./App.php'); ?>

<p class='title-p'>Отделы</p>
    <table border='1'>
        <tr>

            <td>Название отдела</td>
            <td>Количество сотрудников</td>
            <td>Максимальная зарплата</td>

            <td></td>
            <td></td></tr>


<?php 
$sql = $app->request("SELECT * FROM departments");
while($res = mysqli_fetch_row($sql)){

    $sql_in ="
SELECT MAX(em.salary) FROM employee em 
JOIN employee_department emdp
ON em.id=emdp.id_employee  
JOIN departments dp 
ON emdp.id_department=dp.id 
WHERE dp.id=" . (integer) $res[0] ."
GROUP BY dp.name";
    $sql_in = $app->request( $sql_in );
    $res_in = mysqli_fetch_row($sql_in);

    $sql_count = "
    SELECT COUNT(em.firstname) FROM employee em
    JOIN employee_department emdp
ON em.id=emdp.id_employee  
JOIN departments dp 
ON emdp.id_department=dp.id 
WHERE dp.id=" . (integer)$res[0];
    $sql_count = $app->request($sql_count);
    $res_count = mysqli_fetch_row($sql_count);
    ?>
    <tr>
    <td> <?=$res[1]?> </td>
        <td> <?= ($res_count ? $res_count[0] : '') ?> </td>
    <td> <?=( $res_in ? $res_in[0] : '')?> </td>
    <td><a href='./departments/update.php?id=<?=(integer)$res[0] ?>'>UPDATE</a>
    <td><a href='./departments/delete.php?id=<?=(integer)$res[0] ?>'>DELETE</a>
    </tr>
<?php } ?>
    </table>


    <a class='action' href='./departments/create.php'>Создать</a>

<?php require_once('footer.php'); ?>


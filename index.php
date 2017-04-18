<?php  require_once('header.php'); ?>
<?php  require_once('App.php'); ?>



<?php
$departments = [];
$employees = [];


$sql =$app->request("SELECT id, firstname, lastname, patronymic  FROM employee");
while($tablerows = mysqli_fetch_array($sql, MYSQLI_BOTH))
{
    $employees[] = [(integer)$tablerows[0], $tablerows[1], $tablerows[2], $tablerows[3]];
}

$sql = $app->request("SELECT id, name FROM departments");
while($tablerows = mysqli_fetch_array($sql, MYSQLI_BOTH))
{
    $departments[] = [(integer)$tablerows[0], $tablerows[1]];
} ?>


<table class='tbl'>
    <tr>
    <td></td>
    <?php foreach ($departments as $department){ ?>
        <td><?= $department[1] ?></td>
    <?php } ?>
    </tr>

<?php
$sql = $app->request("CREATE TEMPORARY TABLE temp_table AS( SELECT * FROM `employee_department` )");
for($i = 0; $i < count($employees); $i++){
    echo "<tr><td>" . $employees[$i][1] . ' ' .$employees[$i][2].' '. $employees[$i][3] . "</td>";
        for($k = 0; $k < count($departments); $k++){
            echo "<td class='index__table-td'>";
            $is_in_table = $app->request("SELECT * FROM temp_table  WHERE id_employee =". $employees[$i][0]. " AND id_department =".$departments[$k][0]);
            $res = mysqli_fetch_array($is_in_table, MYSQLI_BOTH);
            echo $res ? '+' : '';
            echo "</td>";
        }
    echo "</tr>";
} echo "</table>" ?>

<?php  require_once('footer.php'); ?>



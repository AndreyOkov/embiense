<?php require_once ('../App.php');

if(isset($_POST['firstname'])){
    $sql = "INSERT INTO employee (firstname, lastname, patronymic, gender, salary)".
        " VALUES ('". $_POST['firstname'] . "','"
        . $_POST['lastname'] . "','"
        . $_POST['patronymic'] . "','"
        . $_POST['gender'] . "',"
        . (integer)$_POST['salary'] .")";
    $result = $app->request( $sql );
    if($result) {
        $sql = "SELECT id FROM employee ORDER BY id DESC LIMIT 1";
        $neweployee = $app->request($sql);
        if ($neweployee) {
            $id = mysqli_fetch_row($neweployee);

            if (isset($_POST['name'])) {
                foreach ($_POST['name'] as $res) {

                    $sql = "INSERT INTO employee_department VALUES (". $id[0] .", ". (integer) $res . ")";
                    $result = mysqli_query($db, $sql);
                    if($result){

                    }
                }
            }
        }


    }
}

require_once ('../header.php');

$depsql = $app->request("SELECT id, name FROM departments");
/// Создание сотрудника ///////////
echo "<form action='create.php' method='post'>";

echo '<input type = "text" name ="firstname" /> </p>';
echo '<input type = "text" name ="lastname" /> </p>';
echo '<input type = "text" name ="patronymic" /> </p>';
echo '<input type = "text" name ="gender" /> </p>';
echo '<input type = "text" name ="salary" /> </p>';
echo '<select class="chosen" multiple="true" name="name[]">';

while($departments = mysqli_fetch_row($depsql)){
    echo '<option value="'.$departments[0].'">'. $departments[1] . '</option>';
}

echo '</select>';
echo '<p><input type="submit" />Создать</p>';
echo "</form>";

require_once ('../footer.php');


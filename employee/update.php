<?php require_once ('../App.php');

if(!empty($_POST)) {
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
            if (isset($_POST['name'])) {
                foreach ($_POST['name'] as $res) {
                    $sql = "INSERT INTO employee_department VALUES (" . (integer)$_POST['id'] . ", " . (integer)$res . ")";
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

require_once ('../header.php');

$sql = "SELECT * FROM employee WHERE id=" .(integer)$_GET['id'];
$result = $app->request($sql);
if($result = mysqli_fetch_array($result, MYSQLI_BOTH)){
    echo "<form action=" . $_SERVER['PHP_SELF'] . " method='post'>";

    echo '<p><label for="firstname">Фамилия:</label> <input type = "text" name ="firstname" value="'. $result['firstname'] .'"/> </p>';
    echo '<p><label for="lastname">Имя:</label><input type = "text" name ="lastname" value="'. $result['lastname'] .'"/> </p>';
    echo '<p><label for="patronymic">Отчество:</label><input type = "text" name ="patronymic" value="'. $result['patronymic'] .'"/> </p>';
    echo '<p><label for="gender">Пол:</label><input type = "text" name ="gender" value="'. $result['gender'] .'"/> </p>';
    echo '<p><label for="salary">З/п:</label><input type = "text" name ="salary" value="'. $result['salary'] .'"/> </p>';
    echo '<p><input type = "hidden" name ="id" value="' . $_GET['id'] . '" /> </p>';
    echo '<p><label>Отделы:</label>';
    echo '<select class="chosen" multiple="true" name="name[]">';
    $depsql = $app->request("SELECT id, name FROM departments");
    while($departments = mysqli_fetch_row($depsql)){
        echo '<option value="'.$departments[0].'">'. $departments[1] . '</option>';
    }

    echo '</select>';
    echo '<p><input type="submit" /></p>';
    echo "</form>";
} require_once ('../footer.php');

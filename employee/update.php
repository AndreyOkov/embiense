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

$curDeps = [];
$req = $app->request("SELECT * FROM employee_department WHERE id_employee=" . $_GET['id']);
while ($row = mysqli_fetch_assoc($req)) {
    $curDeps[] = $row['id_department'];
}

$sql = "SELECT * FROM employee WHERE id=" .(integer)$_GET['id'];
$result = $app->request($sql);
if ($result = mysqli_fetch_array($result, MYSQLI_BOTH)) { ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>

        <p><label for="firstname">Фамилия:</label> <input type="text" name="firstname"
                                                          value="<?= $result['firstname'] ?>"/></p>
        <p><label for="lastname">Имя:</label><input type="text" name="lastname" value="<?= $result['lastname'] ?>"/></p>
        <p><label for="patronymic">Отчество:</label><input type="text" name="patronymic"
                                                           value="<?= $result['patronymic'] ?>"/></p>
        <p><label for="gender">Пол:</label><input type="text" name="gender" value="<?= $result['gender'] ?>"/></p>
        <p><label for="salary">З/п:</label><input type="text" name="salary" value="<?= $result['salary'] ?>"/></p>
        <p><input type="hidden" name="id" value="<?= $_GET['id'] ?>"/></p>

        <p><label>Отделы:</label>
            <select class="chosen" multiple="true" name="name[]">


                <?php
    $depsql = $app->request("SELECT id, name FROM departments");
                while ($departments = mysqli_fetch_row($depsql)) { ?>
                    <option
                        value="<?= $departments[0] ?>" <?= ((array_search($departments[0], $curDeps) !== false) ? ' selected="selected"' : ' ') ?>> <?= $departments[1] ?> </option>
                <?php } ?>
            </select>
        <p><input type="submit"/></p>
    </form>


<?php }
require_once('../footer.php'); ?>

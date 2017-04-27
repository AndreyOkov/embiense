<?php
$allDepartments = [];
$employeeDepartments = [];

$result = $mysqli->query($sql);

while ($row = $result->fetch_assoc()) {
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
?>
<?php if ($type === 'create') : ?>
    <h1>Создание сотрудника</h1>
<?php else : ?>
    <h1>Обновиление данных о сотруднике</h1>
<?php endif; ?>
<form action="?act=apply-emp-<?= $type ?>" method='post' class="well form-horizontal">
    <div class="form-group">
        <label class="control-label col-sm-2" for="firstname">Фамилия:</label>
        <div class="col-sm-10">
            <input id="fn" type="text" name="firstname" value="<?= field($formData, 'firstname') ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">Имя:</label>
        <div class="col-sm-10">
            <input id="ln" type="text" name="lastname" value="<?= field($formData, 'lastname') ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">Отчество:</label>
        <div class="col-sm-10">
            <input id="" type="text" name="patronymic" value="<?= field($formData, 'patronymic') ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">Пол:</label>
        <div class="col-sm-10">
            <input id="" type="text" name="gender" value="<?= field($formData, 'gender') ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">З/п:</label>
        <div class="col-sm-10">
            <input id="" type="text" name="salary" value="<?= field($formData, 'salary') ?>"/>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-10">
            <label class="control-label col-sm-2" for="lastname">Отделы:</label>
            <select class="chosen" multiple="true" name="departments[]">
                <?php optionHelper($allDepartments, $employeeDepartments); ?>
            </select>
        </div>
    </div>
    <p><input type="submit" value="<?php echo($type === 'create' ? 'create' : 'update') ?>"/></p>
    <!--    <p><button type="button" onclick="checkData()" >PRESS</button></p>-->
</form>
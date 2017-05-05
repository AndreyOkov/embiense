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
<form id="myForm" class="col-md-8 col-md-push-2">
    <!--<form id="myForm" action="?act=apply-emp---><? //= $type ?><!--"  class="col-md-8 col-md-push-2" >-->
    <div class="form-group">
        <label class="control-label col-sm-2" for="firstname">Фамилия:</label>
        <input id="fn" type="text" name="firstname" value="<?= field($formData, 'firstname') ?>"/>
        <div class="error-container"></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">Имя:</label>
        <input id="ln" type="text" name="lastname" value="<?= field($formData, 'lastname') ?>"/>
        <div class="error-container"></div>

    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">Отчество:</label>
        <input id="" type="text" name="patronymic" value="<?= field($formData, 'patronymic') ?>"/>
        <div class="error-container"></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">Пол:</label>
        <input id="" type="text" name="gender" value="<?= field($formData, 'gender') ?>"/>
        <div class="error-container"></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">З/п:</label>
        <input id="" type="text" name="salary" value="<?= field($formData, 'salary') ?>"/>
        <div class="error-container"></div>
    </div>
    <input type="hidden" name="id" value="<?= field($formData, 'id') ?> "/>
    <div class="form-group">
            <label class="control-label col-sm-2" for="lastname">Отделы:</label>
            <select class="chosen" multiple="true" name="departments[]">
                <?php optionHelper($allDepartments, $employeeDepartments); ?>
            </select>
    </div>
    <p><input type="submit" value="<?php echo($type === 'create' ? 'create' : 'update') ?>"/></p>
</form>
<script>

    $("#myForm").jqueryValidate({
        url: "/server.php",
        validateCallback: function (data) {
            submit();
        },
        errorContainer: '.error-container'
    });


    function submit() {

        $("#myForm").jqueryValidate({
            submit: true,
            url: "/server.ok.php",
            validateCallback: function (data) {
                window.location = "?act=employees";
            }
        });
    }
</script>
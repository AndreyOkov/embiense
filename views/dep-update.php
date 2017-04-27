<?php if ($type === 'create') : ?>
    <h1>Создание отдела</h1>
<?php else : ?>
    <h1>Обновиление данных об отделе</h1>
<?php endif; ?>

<form action="?act=apply-dep-<?= $type ?>" method='post' class="well form-horizontal">
    <p><label class="control-label" for="name">Название отдела:</label>
        <input type="text" name="name" value="<?= field($formData, 'name') ?>"/></p>
    <p><input type="hidden" name="id" value="<?= field($formData, 'id') ?> "/></p>
    <p><input type="submit" value="<?php echo($type === 'create' ? 'create' : 'update') ?>"/></p>
</form>

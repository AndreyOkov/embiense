<table class="table table-bordered">
    <tr>
        <th></th>
        <?php foreach ($departments as $department_name) : ?>
            <th><?php echo $department_name; ?></th>
        <?php endforeach; ?>
    </tr>
    <tbody>
    <?php foreach ($employees as $employee) : ?>
        <tr>
            <th><?php echo $employee['name']; ?></th>
            <?php foreach ($departments as $department_id => $department_name) : ?>
                <td class="index__table-td">
                    <?php echo(in_array($department_id, $employee['departments']) ? '+' : '-'); ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
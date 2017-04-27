<h1>Сотрудники</h1>
<table class="table table-bordered">
    <tr>
        <td>ФИО</td>
        <td>Пол</td>
        <td>З/п</td>
        <td>Отдел</td>
        <td></td>
        <td></td>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= $row['fio'] ?></td>
            <td><?= $row['gender'] ?></td>
            <td><?= $row['salary'] ?></td>
            <td width="300"><?= $row['departments'] ?></td>
            <td class="index__table-td">
                <a href="?act=emp-update&id=<?= $row['em_id'] ?>" class="glyphicon glyphicon-edit"></a>
            </td>
            <td class="index__table-td">
                <a href="?act=emp-delete&id=<?= $row['em_id'] ?>" class="glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<a class='action' href='?act=emp-create'>СОЗДАТЬ</a>
    
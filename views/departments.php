<h1>Отделы</h1>
<table class="table table-bordered">
    <thead>
    <tr>
        <td>Название отдела</td>
        <td>Количество сотрудников</td>
        <td>Максимальная зарплата</td>
        <td></td>
        <td></td>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $res->fetch_assoc()) : ?>
        <tr>
            <th> <?= $row['department_name'] ?> </th>
            <td> <?= ($row ? $row['employee_count'] : '') ?> </td>
            <td> <?= ($row ? $row['max_salary'] : '') ?> </td>
            <td class="index__table-td">
                <a href='?act=dep-update&id=<?= intval($row['id']) ?>' class="glyphicon glyphicon-edit"></a>
            </td>
            <td class="index__table-td">
                <a href='?act=dep-delete&id=<?= intval($row['id']) ?>' class="glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<a class='action' href='?act=dep-create'>Создать</a>
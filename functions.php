<?php
function field($model, $fieldname)
{
    return $model[$fieldname] ?: '';
}

function optionHelper($allDepartments, $employeeDepartments = [])
{
    foreach ($allDepartments as $departmentID => $department) {
        $select = isset($employeeDepartments) ?
            (in_array($department, $employeeDepartments) ? 'selected="selected"' : '') : '';
        echo "<option value=\"$departmentID\" $select > $department </option> <br>";
    }
}

function addDepartmentsToEmployee($idEmployee, $mysqli)
{
    if (isset($_POST['departments'])) {
        foreach ($_POST['departments'] as $idDepartment) {
            $sql = "INSERT INTO employee_department
                    VALUES (" . (integer)$idEmployee . ", " . (integer)$idDepartment . ")";

            $result = $mysqli->query($sql);
            return $result;
        }
    }
}
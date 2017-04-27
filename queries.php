<?php
$sqls = [
    'index' =>
        'SELECT 
                      e.id, 
                      d.id AS department_id, 
                      d.name AS department_name,
                      CONCAT_WS(" ", e.firstname, e.lastname, e.patronymic) AS name
                FROM  departments d 
                      LEFT JOIN employee_department ed ON d.id = ed.id_department
                      LEFT JOIN employee e             ON e.id = ed.id_employee
                ORDER BY e.id',

    'employees' =>
        "SELECT DISTINCT 
                      em.id AS em_id, 
                      CONCAT_WS(' ', em.firstname, em.lastname, em.patronymic) AS fio,
                      em.gender, 
                      em.salary, 
                          (SELECT 
                                GROUP_CONCAT( dp.name ) AS deps
                          FROM 
                               employee em
                               JOIN employee_department emdp   ON em.id = emdp.id_employee
                               JOIN departments dp             ON emdp.id_department = dp.id  
                          WHERE   
                               em.id = em_id) AS departments
                               
                FROM employee em",
    'departments' =>
        "SELECT 
                      d.id,
                      d.name department_name,
                      COUNT(e.firstname) employee_count, 
                      MAX(e.salary) max_salary
                FROM 
                      departments d
                      LEFT JOIN employee_department ed  ON d.id = ed.id_department
                      LEFT JOIN employee e 			    ON ed.id_employee = e.id
                GROUP BY d.name"
];
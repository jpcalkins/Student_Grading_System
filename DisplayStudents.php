<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/26/15
 * Time: 6:21 PM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('admin'));
if(count($_POST) == 0){
    printTable('SELECT * FROM Students');
    $dropdown = '<form action="DisplayStudents.php" method="post">
        Select student to display:<br><select name="userId">';
    $query = 'SELECT userId, name FROM Students GROUP BY userId ASC';
    $result = sqlLogin()->query($query);
    foreach($result as $row){
        $dropdown .= "\r\n<option value='{$row['userId']}'>{$row['userId']}-{$row['name']}</option>";

    }
    $dropdown .= "\r\n</select><input type='submit'></form>";
    echo $dropdown;
} else{
    $userId = $_POST['userId'];
    $query = "SELECT DISTINCT name AS Name, classNum AS 'Class Number', className AS 'Class Name', creditHours AS 'Credit Hours', grade
FROM Students
	JOIN Takes
		ON Takes.userId = Students.userId
	JOIN Classes
		ON Classes.classId = Takes.classId
WHERE Students.userId = '{$userId}'";
    printTable($query);
}
home();
<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/26/15
 * Time: 6:45 PM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('admin'));
if(count($_POST) == 0){
    printTable(sqlLogin(),'SELECT * FROM Instructors');
} elseif(count($_POST) == 1){
    $userId = $_POST['userId'];
    $query = "SELECT DISTINCT name AS Name, classNum AS 'Class Number', className AS 'Class Name', sectionNum AS 'Section Number', creditHours AS 'Credit Hours',semester AS Semester, year AS Year
FROM Instructors
	JOIN Teaches
		ON Teaches.userId = Instructors.userId
	JOIN Classes
		ON Classes.classId = Teaches.classId
WHERE Instructors.userId = '{$userId}'";
    printTable(sqlLogin(),$query);
} elseif(count($_POST) == 2){
    $userId = $_POST['userId'];
    $classId = $_POST['classId'];
    $query = "INSERT INTO Teaches (userId, classId) VALUES ('{$userId}', '{$classId}')";
    multiQuery(sqlLogin(), $query);
}
echo '<a href="RemoveInstructor.php">Remove Instructor From Class</a>';
displayTeacher();
assignTeacher();
home();



function assignTeacher(){
    $dropdown = '<h3>Assign Teacher</h3><br>
<form action="DisplayInstructors.php" method="post">
    User Id:<br><select name="userId">';
    $query = 'SELECT userId, name FROM Instructors GROUP BY userId ASC';
    $result = sqlLogin()->query($query);
    foreach($result as $row){
        $dropdown .= "\r\n<option value='{$row['userId']}'>{$row['userId']}-{$row['name']}</option>";

    }
    $dropdown .= '\r\n</select><br>Class Id:<br><select name="classId">';
    $query = 'SELECT classId, className, sectionNum FROM Classes GROUP BY classId ASC';
    $result = sqlLogin()->query($query);
    foreach($result as $row){
        $dropdown .= "\r\n<option value='{$row['classId']}'>{$row['classId']}-{$row['className']} Section: {$row['sectionNum']}</option>";

    }
    $dropdown .= "\r\n</select><input type='submit'></form>";
    echo $dropdown;
}
function displayTeacher(){
    $dropdown = '<form action="DisplayInstructors.php" method="post">
        Select instructor to display:<br><select name="userId">';
    $query = 'SELECT userId, name FROM Instructors GROUP BY userId ASC';
    $result = sqlLogin()->query($query);
    foreach($result as $row){
        $dropdown .= "\r\n<option value='{$row['userId']}'>{$row['userId']}-{$row['name']}</option>";

    }
    $dropdown .= "\r\n</select><input type='submit'></form>";
    echo $dropdown;
}
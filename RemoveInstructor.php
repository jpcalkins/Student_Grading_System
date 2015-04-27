<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/26/15
 * Time: 7:28 PM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('admin'));
if(count($_POST) == 0){
    removeTeacher();
} elseIf(count($_POST) == 2){
    $classId = $_POST['classId'];
    $userId = $_POST['userId'];
    $query = "DELETE FROM Teaches WHERE classId='{$classId}' AND userId='{$userId}'";
    multiQuery(sqlLogin(), $query);
    removeTeacher();
}
home();
function removeTeacher(){
    printTable('SELECT userId, name, classId, className FROM Instructors NATURAL JOIN Teaches NATURAL JOIN Classes');
    $dropdown = '<form action="RemoveInstructor.php" method="post">
        Select Instructor:<br><select name="userId">';
    $query = 'SELECT userId, name FROM Instructors GROUP BY userId ASC';
    $result = sqlLogin()->query($query);
    foreach($result as $row){
        $dropdown .= "\r\n<option value='{$row['userId']}'>{$row['userId']}-{$row['name']}</option>";

    }
    $dropdown .= "\r\n</select><br>Select Class:<br><select name='classId'>";
    $query = 'SELECT classId, className FROM Classes GROUP BY classId ASC';
    $result = sqlLogin()->query($query);
    foreach($result as $row){
        $dropdown .= "\r\n<option value='{$row['classId']}'>{$row['classId']}-{$row['className']}</option>";

    }
    $dropdown .= "\r\n</select><input type='submit'></form>";
    echo $dropdown;
}
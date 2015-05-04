<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 5/3/15
 * Time: 10:52 PM
 */
include "Project1.php";
session_start();
css();
checkSession(array('instructor'));
if(count($_POST) == 0){
    $dropdown = "<h2>Add Assignment Grade:</h2><form action='Grading.php' method='post'>
    Assignment Name:<br><select name='assignmentName'>";
    $query = "SELECT assignmentName, classId
    FROM Assignments NATURAL JOIN Classes NATURAL JOIN Teaches
    WHERE userId={$_SESSION['userId']} AND open=TRUE";
    $result = sqlLogin()->query($query);
    foreach ($result as $row) {
        $dropdown .= "\r\n<option value='{$row['assignmentName']}|{$row['classId']}'>{$row['classId']}-{$row['assignmentName']}</option>";
    }
    $dropdown .= "\r\n</select><br>Student:<br><select name='studentId'>";
    $query = "SELECT name, userId
              FROM Students";
    $result = sqlLogin()->query($query);
    foreach ($result as $row) {
        $dropdown .= "\r\n<option value='{$row['userId']}'>{$row['userId']}-{$row['name']}</option>";
    }
    $dropdown .= "\r\n</select><br>Grade:<br><input type='number' name='points'>";
    echo $dropdown;
    echo "<br><input type='submit'></form>";
}elseif(count($_POST) == 3){
    $postData = explode('|', $_POST['assignmentName']);
    $classId = $postData[1];
    $assignmentName = $postData[0];
    $query = "INSERT INTO AssignmentGrades (classId, assignmentName, studentId, points) VALUE ({$classId}, '{$assignmentName}', {$_POST['studentId']}, {$_POST['points']})";
    multiQuery(sqlLogin(), $query);
}
home();
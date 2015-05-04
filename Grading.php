<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 5/3/15
 * Time: 10:52 PM
 */
include "Project1.php";
session_start();
if(count($_POST) == 0){
    css();
    checkSession(array('instructor'));
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

    echo "<script src='Project1.js'></script><script src='jquery-1.11.2.min.js'></script>";
    $dropdown = "<h2>Add Final Grade</h2><br>Select Class:<br>
                <select name='classId' onchange='showClassList(this.value)'>";
    $query = "SELECT classId, classNum, className FROM Classes NATURAL JOIN Teaches WHERE userId={$_SESSION['userId']} AND open=TRUE";
    $result = sqlLogin()->query($query);
    $dropdown .= "\r\n<option>Select a class</option>";
    foreach ($result as $row) {
        $dropdown .= "\r\n<option value='{$row['classId']}'>{$row['classId']}-{$row['classNum']}-{$row['className']}</option>";

    }
    $dropdown .= "\r\n</select>";
    echo "{$dropdown}<br<br><br><div id='listPrint'></div><div id='textBox'></div>";

}elseif(count($_POST) == 3){
    $postData = explode('|', $_POST['assignmentName']);
    $classId = $postData[1];
    $assignmentName = $postData[0];
    $query = "INSERT INTO AssignmentGrades (classId, assignmentName, studentId, points) VALUE ({$classId}, '{$assignmentName}', {$_POST['studentId']}, {$_POST['points']})";
    multiQuery(sqlLogin(), $query);

} elseif(count($_POST) == 1){
    $query = "SELECT userId, name FROM Takes NATURAL JOIN Students WHERE classId={$_POST['classId']}";
    $result = sqlLogin()->query($query);
    $row = $result->fetch_row();
    $jsonString = array();
    foreach ($result as $row) {
        array_push($jsonString, array($row['userId'], $row['name']));
    }
    $jsonString = json_encode($jsonString);
    echo $jsonString;
    exit();

} elseif(isset($_POST['grade'])){
    $query = "UPDATE Takes SET grade='{$_POST['grade']}' WHERE userId={$_POST['userId']} AND classId={$_POST['classId']}";
    multiQuery(sqlLogin(), $query);
}
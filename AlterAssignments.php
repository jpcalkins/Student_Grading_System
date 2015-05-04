<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 5/3/15
 * Time: 9:38 PM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('instructor'));
if(count($_POST) == 0){
    echo "<h2>Add Assignment</h2><form action='AlterAssignments.php' method='POST'>
    Class Id:<br><select name='classId'>";
    $query = "SELECT className, classNum, classId FROM Classes NATURAL JOIN Teaches NATURAL JOIN Instructors WHERE userId={$_SESSION['userId']} AND open=TRUE";
    $result = sqlLogin()->query($query);
    foreach ($result as $row) {
        $dropdown .= "\r\n<option value='{$row['classId']}'>{$row['classId']}-{$row['classNum']}-{$row['className']}</option>";
    }
    $dropdown .= "\r\n</select>";
    echo $dropdown;
    echo "<br>Assignment Name:<br>
    <input type='text' name='assignmentName'>
    <br>Points Possible:<br>
    <input type='text' name='numPoints'>
    <br><input type='submit'></form>";

    $dropdown = "<h2>Remove Assignment:</h2><form action='AlterAssignments.php' method='post'>
    Assignment Name:<br><select name='assignmentName'>";
    $query = "SELECT assignmentName, classId
    FROM Assignments NATURAL JOIN Classes NATURAL JOIN Teaches
    WHERE userId={$_SESSION['userId']} AND open=TRUE";
    $result = sqlLogin()->query($query);
    foreach ($result as $row) {
        $dropdown .= "\r\n<option value='{$row['assignmentName']}|{$row['classId']}'>{$row['classId']}-{$row['assignmentName']}</option>";
    }
    $dropdown .= "\r\n</select>";
    echo $dropdown;
    echo "<br><input type='submit'></form>";

    $dropdown = "<h2>Alter Assignment</h2><form action='AlterAssignments.php' method='post'>
    Assignment Name:<br><select name='assignmentName'>";
    $query = "SELECT assignmentName, classId
    FROM Assignments NATURAL JOIN Classes NATURAL JOIN Teaches
    WHERE userId={$_SESSION['userId']} AND open=TRUE";
    $result = sqlLogin()->query($query);
    foreach ($result as $row) {
        $dropdown .= "\r\n<option value='{$row['assignmentName']}|{$row['classId']}'>{$row['classId']}-{$row['assignmentName']}</option>";
    }
    $dropdown .= "\r\n</select>
    <br>Change Assignment Name:<br><input type='text' name='newAssignmentName'>
    <br>Weight:<br><input type='text' name='numPoints'>
    <br><input type='submit'></form>";
    echo $dropdown;

}elseif(count($_POST) == 3 && !isset($_POST['numPoints'])){
    $query = "INSERT INTO Assignments (classId, assignmentName, numPoints) VALUES ({$_POST['classId']}, '{$_POST['assignmentName']}', {$_POST['numPoints']})";
    multiQuery(sqlLogin(), $query);
}elseif(isset($_POST['numPoints'])){
    $postData = explode('|', $_POST['assignmentName']);
    $classId = $postData[1];
    $assignmentName = $postData[0];
    if($_POST['numPoints'] >= 0){
        if(strlen($_POST['newAssignmentName']) == 0){
            $query = "UPDATE Assignments
          SET numPoints={$_POST['numPoints']}
          WHERE classId={$classId} AND assignmentName='{$assignmentName}'";
        }else{
            $query = "UPDATE Assignments
          SET numPoints={$_POST['numPoints']}, assignmentName='{$_POST['newAssignmentName']}'
          WHERE classId={$classId} AND assignmentName='{$assignmentName}'";
        }
    }else{
        $query = "UPDATE Assignments
          SET assignmentName='{$_POST['newAssignmentName']}'
          WHERE classId={$classId} AND assignmentName='{$assignmentName}'";
    }
    multiQuery(sqlLogin(), $query);
}
elseif(count($_POST) == 1){
    $postData = explode('|', $_POST['assignmentName']);
    $classId = $postData[1];
    $assignmentName = $postData[0];
    $query = "DELETE FROM Assignments WHERE classId={$classId} AND assignmentName='{$assignmentName}'";
    multiQuery(sqlLogin(), $query);
}
home();
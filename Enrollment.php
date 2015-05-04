<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/30/15
 * Time: 11:15 AM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('student'));
$query = "SELECT classNum AS 'Class Number', creditHours AS 'Credit Hours', className AS 'Class Name', concat(semester, ' ', year) AS Semester, grade AS Grade
FROM Classes NATURAL JOIN Takes
WHERE userId={$_SESSION['userId']}";
printTable($query);
if(count($_POST) == 0){
    $dropdown = "<form action='Enrollment.php' method='post'>
    Add Class:<br>
    <select name='addClass'>";
    $query = 'SELECT classNum, className, classId FROM Classes WHERE open=TRUE GROUP BY classNum ASC';
    $result = sqlLogin()->query($query);
    foreach($result as $row){
        $dropdown .= "\r\n<option value='{$row['classId']}'>{$row['classId']}-{$row['classNum']}-{$row['className']}</option>";

    }
    $dropdown .= "\r\n</select><input type='submit'></form>";
    echo $dropdown;
    $dropdown = "<form action='Enrollment.php' method='post'>
    Drop Class:<br>
    <select name='dropClass'>";
    $query = "SELECT classNum, className, classId FROM Classes NATURAL JOIN Takes WHERE open=TRUE AND userId={$_SESSION['userId']} GROUP BY classId ASC";
    $result = sqlLogin()->query($query);
    foreach($result as $row){
        $dropdown .= "\r\n<option value='{$row['classId']}'>{$row['classId']}-{$row['classNum']}-{$row['className']}</option>";

    }
    $dropdown .= "\r\n</select><input type='submit'></form>";
    echo $dropdown;
}elseif(isset($_POST['addClass'])){
    $query = "INSERT INTO Takes (userId, classId, grade) VALUES ({$_SESSION['userId']}, {$_POST['addClass']}, 'N')";
    multiQuery(sqlLogin(), $query);
}elseif(isset($_POST['dropClass'])){
    $query = "DELETE FROM Takes WHERE userId={$_SESSION['userId']} AND classId={$_POST['dropClass']}";
    multiQuery(sqlLogin(), $query);
}
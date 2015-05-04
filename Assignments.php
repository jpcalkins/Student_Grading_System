<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 5/1/15
 * Time: 1:00 PM
 */
include 'Project1.php';
session_start();
if($_SESSION['role'] == 'student') {
    if (count($_POST) == 0) {
        css();
        checkSession(array('student'));
        echo "<script src='Project1.js'></script><script src='jquery-1.11.2.min.js'></script>";
        $userId = $_SESSION['userId'];
        $dropdown = "Select Class:<br>
            <select name='classId' onchange='showTable(this.value)'>";
        $query = "SELECT className, classNum, classId FROM Classes NATURAL JOIN Takes WHERE userId={$_SESSION['userId']}";
        $result = sqlLogin()->query($query);
        foreach ($result as $row) {
            $dropdown .= "\r\n<option value='{$row['classId']}'>{$row['classId']}-{$row['classNum']}-{$row['className']}</option>";
        }
        $dropdown .= "\r\n</select>";
        echo "{$dropdown}<br<br><br><div id='tablePrint'></div>";
    }elseif(count($_POST) == 1) {
        $query = "SELECT SUM(points), SUM(numPoints)
    FROM  AssignmentGrades NATURAL JOIN Assignments
    WHERE studentId = {$_SESSION['userId']} AND Assignments.classId = {$_POST['classId']}";
        $result = sqlLogin()->query($query);
        $row = $result->fetch_row();
        $grade = (($row[0] / $row[1]) * 100);
        $query = "SELECT Assignments.assignmentName, concat(points, '/', numPoints) AS Grade
    FROM  AssignmentGrades NATURAL JOIN Assignments
    WHERE studentId = {$_SESSION['userId']} AND Assignments.classId = {$_POST['classId']}";
        $result = sqlLogin()->query($query);
        $row = $result->fetch_row();
        $jsonString = array();
        foreach ($result as $row) {
            array_push($jsonString, array($row['assignmentName'], $row['Grade'], $grade));
        }
        $jsonString = json_encode($jsonString);
        echo $jsonString;
    }
}elseif($_SESSION['role'] == 'instructor'){
    if(count($_POST) == 0){
        css();
        checkSession(array('instructor'));
        echo "<script src='Project1.js'></script><script src='jquery-1.11.2.min.js'></script>";
        $dropdown = "Select Class:<br>
                <select name='classId' onchange='showList(this.value)'>";
        $query = "SELECT classId, classNum, className FROM Classes NATURAL JOIN Teaches WHERE userId={$_SESSION['userId']}";
        $result = sqlLogin()->query($query);
        foreach ($result as $row) {
            $dropdown .= "\r\n<option value='{$row['classId']}'>{$row['classId']}-{$row['classNum']}-{$row['className']}</option>";

        }
        $dropdown .= "\r\n</select>";
        echo "{$dropdown}<br<br><br><div id='listPrint'></div><div id='tablePrint'></div>";
    }elseif(isset($_POST['classId'])){
        $query = "SELECT assignmentName FROM Assignments WHERE classId={$_POST['classId']}";
        $result = sqlLogin()->query($query);
        $jsonString = array();
        foreach ($result as $row) {
            array_push($jsonString, array($row['assignmentName']));
        }
        $jsonString = json_encode($jsonString);
        echo $jsonString;
    }elseif(isset($_POST['assignmentName'])){
        $query = "SELECT userId, name, concat(points, '/', numPoints) AS Grade
          FROM Assignments NATURAL JOIN AssignmentGrades JOIN Students
            ON AssignmentGrades.studentId = Students.userId
          WHERE assignmentName='{$_POST['assignmentName']}'";
        $result = sqlLogin()->query($query);
        $row = $result->fetch_array(MYSQL_ASSOC);
        $jsonString = array();
        foreach ($result as $row){
            array_push($jsonString, array($row['userId'], $row['name'], $row['Grade']));
        }
        $jsonString = json_encode($jsonString);
        echo $jsonString;
    }
}
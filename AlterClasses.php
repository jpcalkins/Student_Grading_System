<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/26/15
 * Time: 8:01 PM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('admin'));
if(count($_POST) == 10){
    $classId = $_POST['classId'];
    $className = $_POST['className'];
    $classNum = $_POST['classNum'];
    $sectionNum = $_POST['sectionNum'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];
    $creditHours = $_POST['creditHours'];
    $maxEnrollment = $_POST['maxEnrollment'];
    $open = $_POST['open'];
    $finished = $_POST['finished'];
    $query = "INSERT INTO Classes (classId, className, classNum, sectionNum, semester, year, creditHours, maxEnrollment, open, finished)
VALUES ({$classId}, '{$className}', '{$classNum}', {$sectionNum}, '{$semester}', {$year}, {$creditHours}, {$maxEnrollment}, {$open}, {$finished})";
    multiQuery(sqlLogin(), $query);
}
addClass();
home();

function addClass(){
    $query = "SELECT classId, className, classNum, sectionNum, semester, year, creditHours, maxEnrollment FROM Classes";
    printTable($query);
    echo '<form action="AlterClasses.php" method="post">
    Class Id:<br>
    <input type="text" name="classId">
    <br>Class Name:<br>
    <input type="text" name="className">
    <br>Class Number:<br>
    <input type="text" name="classNum">
    <br>Section Number:<br>
    <input type="text" name="sectionNum">
    <br>Semester:<br>
    <input type="text" name="semester">
    <br>Year:<br>
    <input type="text" name="year">
    <br>Credit Hours:<br>
    <input type="text" name="creditHours">
    <br>Maximum Number of Students:<br>
    <input type="text" name="maxEnrollment">
    <br>Open(1 for yes, 0 for no):<br>
    <input type="text" name="open">
    <br>Finished(1 for yes, 0 for no):<br>
    <input type="text" name="finished">
    <input type="submit">';
}
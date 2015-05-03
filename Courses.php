<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 5/3/15
 * Time: 6:32 PM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('instructor'));
if(count($_POST) == 0){
    $query = "SELECT classId AS 'Class Id', classNum AS 'Class Number', className AS 'Class Name', sectionNum AS 'Section Number', concat(semester, ' ', year) AS Term, maxEnrollment AS 'Max. Enrollment'
        FROM Classes NATURAL JOIN Teaches
        WHERE userId={$_SESSION['userId']} AND open=TRUE";
    echo "<h2>Open Courses</h2>";
    printTable($query);
    $query = "SELECT classId AS 'Class Id', classNum AS 'Class Number', className AS 'Class Name', sectionNum AS 'Section Number', concat(semester, ' ', year) AS Term, maxEnrollment AS 'Max. Enrollment'
        FROM Classes NATURAL JOIN Teaches
        WHERE userId={$_SESSION['userId']} AND open=FALSE";
    echo "<br><h2>Closed Courses</h2>";
    printTable($query);
}
home();
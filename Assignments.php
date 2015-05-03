<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 5/1/15
 * Time: 1:00 PM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('student'));
$userId = $_SESSION['userId'];
$dropdown = "Select Class:<br>
    <select name='classId' onchange='showTable(this.value, {$userId})'>";
$query = "SELECT className, classNum, classId FROM Classes NATURAL JOIN Takes WHERE userId={$_SESSION['userId']}";
$result = sqlLogin()->query($query);
foreach($result as $row){
    $dropdown .= "\r\n<option value='{$row['classId']}'>{$row['classNum']}-{$row['className']}</option>";

}
$dropdown .= "\r\n</select><input type='submit'></form>";
echo $dropdown;
if(count($_POST) == 1){

}
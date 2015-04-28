<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/28/15
 * Time: 11:03 AM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('admin'));
if(count($_POST) == 3){
    $classNum = $_POST['classNum'];
    $prereqClassNum = $_POST['prereqClassNum'];
    if(isset($_POST['insert'])){
        $query = "INSERT INTO Prerequisites (requiringClassNum, requiredClassNum) VALUES ('{$classNum}', '{$prereqClassNum}')";
    } elseif(isset($_POST['delete'])){
        $query = "DELETE FROM Prerequisites WHERE requiringClassNum='{$classNum}' AND requiredClassNum='{$prereqClassNum}'";
    }
    multiQuery(sqlLogin(), $query);
}
$query = "SELECT DISTINCT requiringClassNum AS Class, requiredClassNum AS Prerequisites, className AS 'Class Name'
FROM Prerequisites JOIN Classes
  ON Classes.classNum = Prerequisites.requiredClassNum";
printTable($query);
$dropdown = '<form action="AlterPrerequisites.php" method="post">
    Class:<br><select name="classNum">';
$query = "SELECT classNum, className FROM Classes GROUP BY classNum ASC";
$result = sqlLogin()->query($query);
foreach($result as $row){
    $dropdown .= "\r\n<option value='{$row['classNum']}'>{$row['classNum']}-{$row['className']}</option>";

}
$dropdown .= "\r\n</select><br>Prerequisite:<br><select name='prereqClassNum'>";
$result = sqlLogin()->query($query);
foreach($result as $row){
    $dropdown .= "\r\n<option value='{$row['classNum']}'>{$row['classNum']}-{$row['className']}</option>";

}
$dropdown .= "\r\n</select><br><input type='submit' name='insert' value='Insert'><input type='submit' name='delete' value='Delete'></form>";
echo $dropdown;
home();
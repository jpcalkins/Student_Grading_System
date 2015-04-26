<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/23/15
 * Time: 5:43 PM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('admin'));
$dropdown = '<form action="DropUser.php" method="post"><select name="userId">';
$query = 'SELECT userId, userName FROM Users WHERE userName <> "'.$_SESSION['userName'].'" GROUP BY userId ASC';
$result = sqlLogin()->query($query);
foreach($result as $row){
    $dropdown .= "\r\n<option value='{$row['userId']}'>{$row['userId']}-{$row['userName']}</option>";

}
$dropdown .= "\r\n</select><input type='submit'></form>";
echo $dropdown;
home();
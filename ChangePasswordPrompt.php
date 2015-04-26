<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/26/15
 * Time: 4:20 PM
 */
include "Project1.php";
session_start();
css();
checkSession(array('admin'));
printTable(sqlLogin(), 'SELECT userId, userName FROM Users GROUP BY userId ASC');
echo '<form action="ChangePassword.php" method="post">
    User Id:<br>
    <input type="text" name="userId">
    <br>Old Password:<br>
    <input type="password" name="oldPass">
    <br>New Password:<br>
    <input type="password" name="newPass">
    <br>Re-enter New Password:<br>
    <input type="password" name="newPass2">
    <br><input type="submit"></form>';
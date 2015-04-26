<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/23/15
 * Time: 12:00 PM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('admin'));
echo '<form action="AddUser.php" method="post">
    Username<br>
    <input type="text" name="userName">
    <br>User Id<br>
    <input type="text" name="userId">
    <br>Role<br>
    <input type="text" name="role">
    <br>Password<br>
    <input type="text" name="password">
    <br>
    <input type="submit" name="login">
    </form>';
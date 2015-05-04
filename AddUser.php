<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/23/15
 * Time: 5:07 PM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('admin'));
if(count($_POST) == 0){
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
}else{
    $userName = $_POST['userName'];
    $userId = $_POST['userId'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    addUser($userName, $userId, $role, $password);
}
home();
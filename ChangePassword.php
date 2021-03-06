<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/26/15
 * Time: 4:29 PM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('admin', 'student'));
if($_SESSION['role'] == 'admin'){
    if(count($_POST) == 0){
        printTable('SELECT userId, userName FROM Users GROUP BY userId ASC');
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
    } else {
        $userId = $_POST['userId'];
        $oldPass = $_POST['oldPass'];
        $newPass = $_POST['newPass'];
        $newPass2 = $_POST['newPass2'];

        if ($newPass != $newPass2 || $newPass == $oldPass) {
            echo 'Error, new password is not valid';
            back();
            exit(0);
        }
        if ($newPass == $newPass2) {
            $query = "SELECT salt, passwordHash FROM Users WHERE userId ='{$userId}'";
            $mysqli = sqlLogin();
            $result = $mysqli->query($query);
            $row = $result->fetch_row();
            $salt = $row[0];
            $storedPass = $row[1];
            if (hashPass($oldPass, $salt) == $storedPass) {
                $salt = generateSalt();
                $query = "UPDATE Users SET salt='{$salt}', passwordHash='" . hashPass($newPass, $salt) . "' WHERE userId='{$userId}'";
                multiQuery($mysqli, $query);
            }
        }
    }
}elseif($_SESSION['role'] == 'student'){
    if(count($_POST) == 0){
        echo '<form action="ChangePassword.php" method="post">
        Old Password:<br>
        <input type="password" name="oldPass">
        <br>New Password:<br>
        <input type="password" name="newPass">
        <br>Re-enter New Password:<br>
        <input type="password" name="newPass2">
        <br><input type="submit"></form>';
    } else {
        $oldPass = $_POST['oldPass'];
        $newPass = $_POST['newPass'];
        $newPass2 = $_POST['newPass2'];

        if ($newPass != $newPass2 || $newPass == $oldPass) {
            echo 'Error, new password is not valid';
            back();
            exit(0);
        }
        if ($newPass == $newPass2) {
            $query = "SELECT salt, passwordHash FROM Users WHERE userName ='{$_SESSION['userName']}'";
            $mysqli = sqlLogin();
            $result = $mysqli->query($query);
            $row = $result->fetch_row();
            $salt = $row[0];
            $storedPass = $row[1];
            if (hashPass($oldPass, $salt) == $storedPass) {
                $salt = generateSalt();
                $query = "UPDATE Users SET salt='{$salt}', passwordHash='" . hashPass($newPass, $salt) . "' WHERE userName='{$_SESSION['userName']}'";
                multiQuery($mysqli, $query);

            }
        }
    }
}
home();
<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/26/15
 * Time: 4:29 PM
 */
include 'Project1.php';
css();
$userId = $_POST['userId'];
$oldPass = $_POST['oldPass'];
$newPass = $_POST['newPass'];
$newPass2 = $_POST['newPass2'];

if ($newPass != $newPass2 || $newPass == $oldPass){
    echo 'Error, new password is not valid';
    back();
    exit(0);
}
if($newPass == $newPass2){
    $query = 'SELECT salt, passwordHash FROM Users WHERE userId = "'.$userId.'"';
    $mysqli = sqlLogin();
    $result = $mysqli->query($query);
    $row = $result->fetch_row();
    $salt = $row[0];
    $storedPass = $row[1];
    if(hashPass($oldPass, $salt) == $storedPass){
        $salt = generateSalt();
        $query = 'UPDATE Users SET salt="'.$salt.'", passwordHash="'.hashPass($newPass, $salt).'" WHERE userId="'.$userId.'"';
        multiQuery($mysqli, $query);
    }
}
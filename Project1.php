<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/15/15
 * Time: 2:06 PM
 */
include 'Pages.php';
include 'SessionJunk.php';

function multiQuery($mysqli, $query){
    if (mysqli_multi_query($mysqli, $query)) {
        echo "Success!";
    } else {
        echo "Error: " . mysqli_error($mysqli);
        exit(0);
    }
}
function generateSalt(){
    $salt = openssl_random_pseudo_bytes(16, $cstrong);
    $salt = bin2hex($salt);
    return $salt;
}
function addUser($userName, $userId, $role, $password){
    $salt = generateSalt();
    $password = hashPass($password, $salt);
    $query = 'INSERT INTO Users (userName, userId, role, salt, passwordHash) VALUES
                  ("'.$userName.'", "'.$userId.'", "'.$role.'", "'.$salt.'", "'.$password.'")';
    multiQuery(sqlLogin(), $query);
}

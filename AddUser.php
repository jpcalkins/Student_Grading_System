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
checkSession($admin);
$userName = $_POST['userName'];
$userId = $_POST['userId'];
$role = $_POST['role'];
$password = $_POST['password'];
addUser($userName, $userId, $role, $password);

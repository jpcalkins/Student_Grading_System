<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/23/15
 * Time: 6:36 PM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('admin'));
$userId = $_POST['userId'];
$query = 'DELETE FROM Users WHERE userId = '.$userId;
multiQuery(sqlLogin(), $query);
home();
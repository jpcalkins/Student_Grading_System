<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/17/15
 * Time: 12:38 PM
 */
include 'Project1.php';
css();
session_start();
if(!isset($_SESSION['role'])){
    siteLogin();
    exit();
} else{
    checkSession();
}
$role = $_SESSION['role'];
if($role == 'admin'){
    adminHome();
} else if($role == 'instructor'){
    instHome();
} else if($role == 'student'){
    studHome();
} else{
    echo 'You don\'t have permission to view this site<br><button onclick="history.go(-1);">Back </button>';
}
<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/22/15
 * Time: 1:39 PM
 */
include 'Project1.php';
session_start();
css();
checkSession();
$query = $_POST['queryText'];
printTable($query);
adminQuery();
home();

<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/26/15
 * Time: 4:56 PM
 */
include 'Project1.php';
session_start();
css();
checkSession(array('admin'));
if(count($_POST) == 0){
    echo '<form action="Search.php" method="post">
            Enter part or all of name to search for:<br>
            <input type="text" name="searchText">
            <input type="submit">
</form>';
    home();
}else{
    $searchText = $_POST['searchText'];
    $query = 'SELECT name FROM Instructors WHERE name LIKE "%'.$searchText.'%" UNION ALL SELECT name FROM Students WHERE name LIKE "%'.$searchText.'%"';
    printTable(sqlLogin(), $query);
    echo '<form action="Search.php" method="post">
            Enter part or all of name to search for:<br>
            <input type="text" name="searchText">
            <input type="submit">
</form>';
    home();
}
<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/23/15
 * Time: 6:14 PM
 */
function signout(){
    session_unset();
    session_destroy();
    header("Location: Home.html");
}
function hashPass($password, $salt){
    $passSalt = $password . $salt;
    return hash('sha256', $passSalt);
}
function newSession($role, $userName, $password){
    $timeout = 3 * 60; // 3 minutes
    if (isset($_SESSION['time']) && time() > $_SESSION['time'] + $timeout) {
        session_unset();
        session_destroy();
        echo('timeout');
        exit(0);
    }
    $_SESSION['time'] = time();
    $_SESSION['role'] = $role;
    $_SESSION['userName'] = $userName;
    $_SESSION['password'] = $password;
}
function checkSession($required = array('student', 'admin', 'instructor')){
    $timeout = 3 * 60;
    if (isset($_SESSION['time']) && time() > $_SESSION['time'] + $timeout) {
        session_unset();
        session_destroy();
        echo'timeout <br><a href="Home.html">Login Again</a>';
        exit(0);
    } elseif (!isset($_SESSION['role'])){
        session_unset();
        session_destroy();
        echo '<a href="Home.html">Login Again</a>';
        exit(0);
    } elseif(isset($_SESSION['role']) && !in_array($_SESSION['role'], $required)){
        echo '<h2>You don\'t have access to this page</h2><br>
            <a href="Signout.php">Signout</a><br>
            <button onclick="history.go(-1);">Back</button>';
        exit(0);
    }
}
function siteLogin(){
    $mysqli = sqlLogin();
    $userName = $_POST['username'];
    $password = $_POST['password'];
    $query = 'SELECT role, salt, passwordHash FROM Users WHERE userName = "'.$userName.'"';
    $result = $mysqli->query($query);
    $row = $result->fetch_row();
    $role = $row[0];
    $salt = $row[1];
    $storedPass = $row[2];
    if(strlen($salt) == 0){
        echo 'Incorrect username or password<br><button onclick="history.go(-1);">Back </button>';
        return;
    }
    $password = hashPass($password, $salt);
    if($password == $storedPass){
        newSession($role, $userName, $password);
    }else{
        echo 'Incorrect username or password<br><button onclick="history.go(-1);">Back </button>';
        return;
    }
}
function sqlLogin(){
    $user = 'jacobpc';
    $database = 'jacobpc';
    $fileText = file_get_contents('dbpass.txt', FILE_USE_INCLUDE_PATH);
    $password = trim($fileText);
    $mysqli = new mysqli("cs.okstate.edu", $user, $password, $database);
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    return $mysqli;
}
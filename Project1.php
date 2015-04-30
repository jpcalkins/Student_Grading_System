<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/15/15
 * Time: 2:06 PM
 */
//User Pages
function adminHome(){
    echo '<h1>Jacob Calkins</h1><br><h2>Username: '.$_SESSION['userName'].'<br>Administrator</h2>
    <form action="CreateTables.php" method="post">
        <input type="submit" name="createTables" value="Create Tables">
    </form>
    <form action="DropTables.php" method="post">
        <input type="submit" name="dropTables" value="Drop Tables">
    </form>
    <form action="PopulateTables.php" method="post">
        <input type="submit" name="populateTables" value="Populate Tables">
    </form><br>
    <a href="AddUser.php">Add Users</a><br>
    <a href="Signout.php">Signout</a><br>
    <a href="DropUserPrompt.php">Drop User</a>
    <a href="ChangePassword.php">Change Password</a>
    <a href="Search.php">Search</a>
    <a href="DisplayStudents.php">Display Students</a>
    <a href="DisplayInstructors.php">Display Instructors</a>
    <a href="AlterClasses.php">View Classes</a>';
    adminQuery();
}
function instHome(){
    echo '<h1>Jacob Calkins</h1><br><h2>Username: '.$_SESSION['userName'].'<br>Instructor</h2>';
}
function studHome(){
    echo '<h1>Jacob Calkins</h1><br><h2>Username: '.$_SESSION['userName'].'<br>Student</h2>
    <br><a href="ChangePassword.php">Change Password</a>
    <br><a href="Signout.php">Signout</a>
    <br><a href="Enrollment.php">Alter Classes</a><br>';
}



//Functional Stuff
function addUser($userName, $userId, $role, $password){
    $salt = generateSalt();
    $password = hashPass($password, $salt);
    $query = "INSERT INTO Users (userName, userId, role, salt, passwordHash) VALUES
                  ('{$userName}', '{$userId}', '{$role}', '{$salt}', '{$password}')";
    multiQuery(sqlLogin(), $query);
}
function adminQuery(){
    echo '<br><form id="generalQuery" name="generalQuery" action="Query.php" method="POST">
    <textarea rows="15" cols="80" name="queryText" form="generalQuery">
    </textarea><br/>
    <input type="submit" value="Submit">
    </form><br/>';
}
function back(){
    echo '<br><button onclick="history.go(-1);">Back </button>';
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
    $_SESSION['time'] = time();
    if($_SESSION['role'] == 'student'){
        $query = "SELECT * FROM Students WHERE userId='{$_SESSION['userId']}'";
        $result = sqlLogin()->query($query);
        $row = $result->fetch_array(MYSQL_ASSOC);
        echo "<pre>Name: {$row['name']}   User Id: {$row['userId']}   Major: {$row['major']}  Year: {$row['year']}</pre>";
    }
}
function css(){
    echo '<head><link rel="stylesheet" href="My.css">';
}
function generateSalt(){
    $salt = openssl_random_pseudo_bytes(16, $cstrong);
    $salt = bin2hex($salt);
    return $salt;
}
function hashPass($password, $salt){
    $passSalt = $password . $salt;
    return hash('sha256', $passSalt);
}
function home(){
    echo '<a href="Homepage.php">Home</a>';
}
function multiQuery($mysqli, $query){
    if (mysqli_multi_query($mysqli, $query)) {
        echo "\nSuccess!";
    } else {
        echo "Error: " . mysqli_error($mysqli);
        back();
        home();
        exit(0);
    }
}
function newSession($role, $userName, $password){
    $timeout = 3 * 60; // 3 minutes
    if (isset($_SESSION['time']) && time() > $_SESSION['time'] + $timeout) {
        session_unset();
        session_destroy();
        echo('timeout');
        exit(0);
    }
    $query = "SELECT userId FROM Users WHERE userName='{$userName}' AND role='{$role}'";
    $result = sqlLogin()->query($query);
    $row = $result->fetch_array(MYSQL_ASSOC);
    $_SESSION['time'] = time();
    $_SESSION['role'] = $role;
    $_SESSION['userName'] = $userName;
    $_SESSION['password'] = $password;
    $_SESSION['userId'] = $row['userId'];
}
function printTable($query){
    $result = sqlLogin()->query($query);
    echo "<pre>\n";
    echo $query;
    echo "\n\n</pre><hr>\n";
    echo '<table border="2" cellPadding="3">';
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row) {
        $keys = array_keys($row);
        echo '<tr>';
        foreach ($keys as $key) {
            echo "<th>$key</th>";
        }
        echo '</tr>';
        while ($row) {
            echo '<tr>';
            foreach ($row as $cell) {
                echo '<td>' . $cell . '</th>';
            }
            echo '</tr>';
            $row = $result->fetch_array(MYSQLI_ASSOC);
        }
    }
    echo "</table>\n";
    echo "<br/><br/><br/>";
}
function signout(){
    session_unset();
    session_destroy();
}
function siteLogin(){
    $mysqli = sqlLogin();
    $userName = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT role, salt, passwordHash FROM Users WHERE userName = '{$userName}'";
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
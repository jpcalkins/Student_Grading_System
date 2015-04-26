<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/23/15
 * Time: 6:15 PM
 */
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
    <a href="AddUserPrompt.php">Add Users</a><br>
    <a href="Signout.php">Signout</a><br>
    <a href="DropUserPrompt.php">Drop User</a>
    <a href="ChangePasswordPrompt.php">Change Password</a>
    <a href="Search.php">Search</a>';
    adminQuery();
}
function instHome(){
    echo '<h1>Jacob Calkins</h1><br><h2>Username: '.$_SESSION['userName'].'<br>Instructor</h2>';
}
function studHome(){
    echo '<h1>Jacob Calkins</h1><br><h2>Username: '.$_SESSION['userName'].'<br>Student</h2>';
}
function home(){
    echo '<a href="Homepage.php">Home</a>';
}
function css(){
    echo '<head><link rel="stylesheet" href="My.css">';
}
function adminQuery(){
    echo '<br><form id="generalQuery" name="generalQuery" action="Query.php" method="POST">
    <textarea rows="15" cols="80" name="queryText" form="generalQuery">
    </textarea><br/>
    <input type="submit" value="Submit">
    </form><br/>';
}
function printTable($mysqli, $query){
    $result = $mysqli->query($query);
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
function dropdownBox(){
    $dropdown = '<form action="DisplayInventories.php" method="post"><select name="storeName">';
    $query = 'SELECT storeName FROM Stores';
    $result = $mysqli->query($query);
    foreach($result as $row){
        $dropdown .= "\r\n<option value='{$row['storeName']}'>{$row['storeName']}</option>";

    }
    $dropdown .= "\r\n</select><input type='submit'></form>";
}
function back(){
    echo '<br><button onclick="history.go(-1);">Back </button>';
}
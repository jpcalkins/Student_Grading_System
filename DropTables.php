<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/20/15
 * Time: 9:39 AM
 */
include 'Project1.php';
session_start();
css();
checkSession();
multiQuery(sqlLogin(), file_get_contents('DropTables.txt'));
echo '    <form action="CreateTables.php" method="post">
        <input type="submit" name="createTables" value="Create Tables">
    </form>';
adminQuery();
home();
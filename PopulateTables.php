<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/20/15
 * Time: 9:41 AM
 */
include 'Project1.php';
session_start();
css();
checkSession();
multiQuery(sqlLogin(), file_get_contents('PopulateTables.txt'));
echo '<form action="DropTables.php" method="post">
        <input type="submit" name="dropTables" value="Drop Tables">
      </form>';
adminQuery();
home();
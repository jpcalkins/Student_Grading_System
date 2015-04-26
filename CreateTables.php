<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/20/15
 * Time: 9:35 AM
 */
include 'Project1.php';
session_start();
css();
checkSession();
multiQuery(sqlLogin(), file_get_contents('AddTables.txt'));
echo '<form action="PopulateTables.php" method="post">
        <input type="submit" name="populateTables" value="Populate Tables">
      </form>
      <form action="DropTables.php" method="post">
        <input type="submit" name="dropTables" value="Drop Tables">
      </form><br><br>';
adminQuery();
home();
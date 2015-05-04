<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 4/23/15
 * Time: 6:09 PM
 */
include 'Project1.php';
css();
session_start();
signout();
echo 'You have been signed out.';
echo '<br><a href="Home.html">Login Again</a>';
<?php
$servername = "localhost";
$username = "root";
$password = "";


$dbh = new PDO("mysql:host=$servername;dbname=tbr;", $username, $password);
    // set the PDO error mode to exception
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

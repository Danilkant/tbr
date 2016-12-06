<?php
$servername = "localhost";
$username = "root";
$password = "P@ssword8912";
$port = 3306;

$dbh = new PDO("mysql:host=$servername;dbname=tbr;port=$port", $username, $password);
    // set the PDO error mode to exception
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

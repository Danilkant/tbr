<?php
require 'init.database.php';

$toReturn = [];

$sth = $dbh->prepare('SELECT
	*
	from game');

$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);
$toReturn = $sth->fetchAll();

echo (json_encode($toReturn, JSON_UNESCAPED_SLASHES));
?>

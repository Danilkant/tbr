<?php
require 'init.database.php';

$toReturn = [];

$sth = $dbh->prepare('SELECT
	c.id AS compID,
	c.compDate AS compDate,
	c.description AS compDescr,
	c.prize AS prize,
	g.name AS gameName,
	g.maxPlayer AS maxPlayers,
	g.localPath AS localPath
	from comp c
	inner join game g on c.games_id = g.id');

$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);
$toReturn = $sth->fetchAll();

echo (json_encode($toReturn, JSON_UNESCAPED_SLASHES));
?>

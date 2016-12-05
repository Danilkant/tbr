<?php
require 'init.database.php';

$data = json_decode(file_get_contents('php://input'));

$teamid = $data->teamid;

$toReturn = [];

$keyword1 = "Comp";

$sth = $dbh->prepare('SELECT
	ct.comp_id AS compID,
	c.compDate AS compDate,
	g.name AS gameName
	from comp_team ct
	inner join comp c on ct.comp_id = c.id
	inner join game g on c.games_id = g.id
	WHERE ct.teams_id = :teamid');

$sth->bindParam(':teamid', $teamid, PDO::PARAM_INT);
$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);
$toReturn = $sth->fetchAll();

echo (json_encode($toReturn, JSON_UNESCAPED_SLASHES));
?>

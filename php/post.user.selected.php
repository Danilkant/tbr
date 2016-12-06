<?php
require 'init.database.php';

$data = json_decode(file_get_contents('php://input'));

$ID = $data->userid;

$toReturn = [];

$tempuserarray = [];
$tempcomparray = [];
$tempteamsarray = [];

$keyword1 = "User";
$keyword2 = "TeamComps";
$keyword3 = "Teams";


$sth = $dbh->prepare('SELECT
	id AS ID,
	username AS Username,
	name AS Name,
	email AS Email,
	imgLink AS imgLink
	FROM
	user WHERE
	id = :ID');

$sth->bindParam(':ID', $ID, PDO::PARAM_INT);
$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);

$tempuserarray = $sth->fetch();

$sth = $dbh->prepare('SELECT
	t.id AS ID,
	t.teamname AS TeamName,
	ct.comp_id AS compID,
	c.compDate AS compDate,
	g.name AS gameName
	from team t
	inner join team_user tu on t.id = tu.team_id
	inner join comp_team ct on tu.team_id = ct.teams_id
	inner join comp c on ct.comp_id = c.id
	inner join game g on c.games_id = g.id
	WHERE tu.user_id = :ID');

$sth->bindParam(':ID', $ID, PDO::PARAM_INT);
$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);
$tempcomparray = $sth->fetchAll();

$result = count($tempcomparray);





$sth = $dbh->prepare('SELECT t.teamname from team t inner join team_user tu on t.id = tu.team_id where tu.user_id = :userid');

$sth->bindParam(':userid', $ID);

$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);
$tempteamsarray = $sth->fetchAll();


$toReturn[$keyword1] = $tempuserarray;
$toReturn[$keyword2] = $tempcomparray;
$toreturn[$keyword3] = $tempteamsarray;

echo (json_encode($toReturn, JSON_UNESCAPED_SLASHES));
?>

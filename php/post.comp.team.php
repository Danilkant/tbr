<?php

require('init.database.php');

$data = json_decode(file_get_contents('php://input'));

$compid = $data->compid;

$teamid = $data->teamid;

$sth = $dbh->prepare('INSERT INTO  comp_team(comp_id, teams_id) VALUES
		(
		:compid,
		:teamid)
    ');

$sth->bindParam(':compid', $compid);
$sth->bindParam(':teamid', $teamid);

$sth->execute();

?>
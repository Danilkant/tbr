<?php

require('init.database.php');

$data = json_decode(file_get_contents('php://input'));

$teamid = $data->teamid;

$compid = $data->compid;

$sth = $dbh->prepare('DELETE  FROM comp_team WHERE teams_id = :teamid AND comp_id = :compid
    ');

$sth->bindParam(':teamid', $teamid);
$sth->bindParam(':compid', $compid);

$sth->execute();
?>
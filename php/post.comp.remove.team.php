<?php

require('init.database.php');

$data = json_decode(file_get_contents('php://input'));

$userid = $data->teamid;

$sth = $dbh->prepare('DELETE  FROM comp_team WHERE teams_id = :teamid
    ');

$sth->bindParam(':teamid', $teamid);

$sth->execute();
?>
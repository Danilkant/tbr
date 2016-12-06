<?php

require('init.database.php');

$data = json_decode(file_get_contents('php://input'));

$userid = $data->userid;

$teamid = $data->teamid;

$sth = $dbh->prepare('DELETE  FROM team_user WHERE user_id = :userid AND team_id = :teamid
    ');

$sth->bindParam(':userid', $userid);
$sth->bindParam(':teamid', $teamid);

$sth->execute();
?>
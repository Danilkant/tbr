<?php

require('init.database.php');

$data = json_decode(file_get_contents('php://input'));

$username = $data->username;

$teamid = $data->teamid;

$sth = $dbh->prepare('INSERT INTO  team_user(team_id, user_id) VALUES
		(:teamid,
		(select id from user where username = :username))
    ');

$sth->bindParam(':teamid', $teamid);
$sth->bindParam(':username', $username);

$sth->execute();

?>
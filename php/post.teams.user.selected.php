<?php

require('init.database.php');

$data = json_decode(file_get_contents('php://input'));

$userid = $data->userid;

$toReturn = [];

$sth = $dbh->prepare('SELECT 
	t.id AS ID,
    t.teamname AS TeamName,
    t.teamOwner AS Owner
	FROM team t
    inner join team_user tu on tu.team_id = t.id
    WHERE 
    	user_id = :userid
    ');

$sth->bindParam(':userid', $userid, PDO::PARAM_INT);

$sth->execute();

$sth->setFetchMode(PDO::FETCH_ASSOC);

$toReturn = $sth->fetchAll();

echo(json_encode($toReturn, JSON_UNESCAPED_SLASHES));

?>
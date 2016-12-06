<?php

require('init.database.php');

$data = json_decode(file_get_contents('php://input'));

$userid = $data->userid;

$toReturn = [];

$sth = $dbh->prepare('SELECT 
	isAdmin
	FROM user
    WHERE 
    	id = :userid
    ');

$sth->bindParam(':userid', $userid, PDO::PARAM_INT);

$sth->execute();

$sth->setFetchMode(PDO::FETCH_ASSOC);

$toReturn = $sth->fetch();

if($toReturn == null)
	$toReturn = false;
else
	$toReturn = true;

echo(json_encode($toReturn, JSON_UNESCAPED_SLASHES));

?>
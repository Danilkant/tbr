<?php

require('init.database.php');

$data = json_decode(file_get_contents('php://input'));

$userid = $data->userid;

$toReturn = [];

$sth = $dbh->prepare('
	SELECT 
		t.id as ID,
		t.teamname as Name,
		t.teamtag as Tag,
		t.description as Descr,
		t.imgLink as ImgLink,
		t.teamOwner as Owner
	FROM team t
	inner join team_user tu on tu.team_id = t.id
	WHERE
		tu.user_id = :userid
    ');

$sth->bindParam(':userid', $userid);

$sth->execute();

$sth->setFetchMode(PDO::FETCH_ASSOC);

$toReturn = $sth->fetchAll();

echo(json_encode($toReturn, JSON_UNESCAPED_SLASHES));

?>
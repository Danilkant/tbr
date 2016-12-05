<?php

require('init.database.php');

$data = json_decode(file_get_contents('php://input'));

$ID = $data->teamid;

$toReturn = [];

$temparr1 = [];
$temparr2 = [];

$keyword1 = "Team";
$keyword2 = "User";

$sth = $dbh->prepare('SELECT 
		id as ID,
		teamname as Name, 
		teamtag as Tag, 
		description as Descr, 
		imgLink as ImgLink,
		teamOwner as Owner
    from team
    where id = :ID
    ');

$sth->bindParam(':ID', $ID, PDO::PARAM_INT);

$sth->execute();

$sth->setFetchMode(PDO::FETCH_ASSOC);

$temparr1 = $sth->fetch();

$sth = $dbh->prepare('SELECT 
		u.id as ID, 
		u.username as Name

    from team_user tu
    inner join user u on tu.user_id = u.id
    where tu.team_id = :ID
    ');

$sth->bindParam(':ID', $ID, PDO::PARAM_INT);

$sth->execute();

$sth->setFetchMode(PDO::FETCH_ASSOC);

$temparr2 = $sth->fetchAll();

$toReturn[$keyword1] = $temparr1;
$toReturn[$keyword2] = $temparr2;

echo(json_encode($toReturn, JSON_UNESCAPED_SLASHES));

?>
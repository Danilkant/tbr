<?php
    require('init.database.php');

    $data = json_decode(file_get_contents('php://input'));

    $teamname = $data->teamname;

    $teamtag = $data->teamtag;

    $description = $data->desc;

    $teamOwner = $data->userid;

    $sth = $dbh->prepare('INSERT IGNORE INTO team(teamname, teamtag, description, teamOwner)
                    VALUES (:teamname, :teamtag, :description, :teamOwner)');
    $sth->bindParam(':teamname', $teamname);
    $sth->bindParam(':teamtag', $teamtag);
    $sth->bindParam(':description', $description);
    $sth->bindParam(':teamOwner', $teamOwner);

    $sth = $dbh->prepare('INSERT INTO team_user(team_id, user_id) VALUES ((SELECT id FROM team where teamname = :teamname), :teamOwner)');
    $sth->bindParam(":teamname", $teamname);
    $sth->bindParam(":teamOwner", $teamOwner);
    $sth->execute();
?>

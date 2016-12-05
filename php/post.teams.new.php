<?php
    require('init.database.php');

    $data = json_decode(file_get_contents('php://input'));

    $teamname = $data->teamname;

    $teamtag = $data->teamtag;

    $description = $data->desc;

    $sth = $dbh->prepare('INSERT IGNORE INTO teams(teamname, teamtag, description)
                    VALUES (:teamname, :teamtag, :description)');
    $sth->bindParam(':teamname', $teamname);
    $sth->bindParam(':teamtag', $teamtag);
    $sth->bindParam(':description', $description);
              
    $sth->execute();
?>
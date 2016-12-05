<?php
    require('init.database.php');

    $data = json_decode(file_get_contents('php://input'));

    $teamid = $data->teamid;

    $description = $data->desc;

    $imglink = $data->imglink;

    $sth = $dbh->prepare('UPDATE team
        SET description = :description , imgLink = :imglink WHERE id = :teamid');
    $sth->bindParam(':description', $description);
    $sth->bindParam(':imglink', $imglink);
    $sth->bindParam(':teamid', $teamid);
              
    $sth->execute();
?>
<?php
    require('init.database.php');

    $data = json_decode(file_get_contents('php://input'));

    $teamid = $data->teamid;

    $sth = $dbh->prepare('DELETE FROM teams WHERE id = :teamid');
    $sth->bindParam(':teamid', $teamid);
              
    $sth->execute();
?>
<?php

require('init.database.php');

$data = json_decode(file_get_contents('php://input'));

$userid = $data->userid;

$sth = $dbh->prepare('DELETE  FROM team_user WHERE user_id = :userid
    ');

$sth->bindParam(':userid', $userid);

$sth->execute();
?>
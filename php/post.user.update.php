<?php
    require('init.database.php');

    $data = json_decode(file_get_contents('php://input'));

    $userid = $data->userid;

    $username = $data->username;

    $email = $data->email;

    $cost = 10;


    $sth = $dbh->prepare('UPDATE user
        SET username = :username, email = :email WHERE id = :userid');
    $sth->bindParam(':username', $username);
    $sth->bindParam(':userid', $userid);
    $sth->bindParam(':email', $email);

    $sth->execute();
?>

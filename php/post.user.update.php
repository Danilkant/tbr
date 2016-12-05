<?php
    require('init.database.php');

    $data = json_decode(file_get_contents('php://input'));

    $userid = $data->id;

    $name = $data->name;

    $password = $data->password;

    $email = $data->email;

    $cost = 10;

    // Create a random salt
    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

    // Prefix information about the hash so PHP knows how to verify it later.
    // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
    $salt = sprintf("$2a$%02d$", $cost) . $salt;

    // Hash the password with the salt
    $hash = crypt($password, $salt);

    $sth = $dbh->prepare('UPDATE user
        SET name = :name , imgLink = :imglink , password = :hash , email = :email WHERE id = :userid');
    $sth->bindParam(':name', $name);
    $sth->bindParam(':imglink', $imglink);
    $sth->bindParam(':userid', $userid);
    $sth->bindParam(':hash', $hash);
    $sth->bindParam(':email', $email);
              
    $sth->execute();
?>
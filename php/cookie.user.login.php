<?php
    require('init.database.php');

    $data = json_decode(file_get_contents('php://input'));

    $username = $data->username;

    $password = $data->password;

    $cost = 10;

    $sth = $dbh->prepare('SELECT id, password FROM user WHERE username = :username');
    $sth->bindParam(':username', $username);
              
    $sth->execute();

    $user = $sth->fetch(PDO::FETCH_OBJ);

	// Hashing the password with its hash as the salt returns the same hash
	if ( hash_equals($user->password, crypt($password, $user->password)) ){
	  
	  	echo $user->id;
	}else{
		echo "false";
	}
?>
<?php

$sql = 'SELECT * FROM user WHERE username = :username';

//Preparation 
$stmt = $connection->prepare($sql);
try {
    //Executed and user bound to $
	$stmt->execute(array(':username'=>$user_name_from_login));
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($results as $row) {
		$database_password_hash = $row[ 'password' ];
	}

    //Password hashed using blowfish encryption
	$user_password_rehashed = crypt($user_password_from_login, $database_password_hash);	

} catch (Exception $e) {
	echo $e->getMessage();
}
/*
if 
($user_password_rehashed == $database_password_hash) {
echo '<br>';
echo ' User’s login password “IS A MATCH” with the one in database (:';
echo '<br>';
}
else 
{
echo '<br>';    
echo ' User’s login password “DOES NOT MATCH” with the one in database ):';
echo '<br>';
}

echo '<br>';
echo ' $user_password_from_login = ' . $user_password_from_login;
echo '<br>';
echo ' $user_password_rehashed --- = ' . $user_password_rehashed;
echo '<br>'; 
echo ' $database_password_hash ---  = ' . $database_password_hash;
echo '<br>';
*/
$storedPwd = $user_password_rehashed;

// check the submitted password against the stored version, matches a hash
// password_verify virkar ekki á tsuts.tskoli.is (eldri útgáfa af php á miðlaranum)
// if (password_verify($password, $storedPwd)) {

  if ($storedPwd){       
    $_SESSION['authenticated'] = 'Jethro Tull';
    // get the time the session started
    $_SESSION['start'] = time();
    session_regenerate_id();
    header("Location: $redirect"); exit;
} else {
    // if not verified, prepare error message
    $error = 'Invalid username or password';
}

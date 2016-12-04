<?php

if (isset($_POST['login'])) {    
    $user_name_from_login = trim($_POST['username']);
    $user_password = trim($_POST['password']);
    // use sessionm if the form has been submitted
    
    // location to redirect on success, stored in a variable
    $redirect = 'http://tsuts.tskoli.is/2t/0807932279/Lokaverkefni/hello.php';  
    require 'encryption.php';
}

$sql = 'SELECT * FROM user WHERE username = :username';
//Preparation 
$stmt = $connection->prepare($sql);
try {
    //Executed and user bound to a variable
    $stmt->execute(array(':username'=>$user_name_from_login));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $database_password_hash = $row[ 'password' ];
    }    
} catch (Exception $e) {
    echo $e->getMessage();
}

if ($database_password_hash == $row['password']) {    
    echo 'This password is OK';
    return true;
}

else
{
    echo 'This password is not okay!';    
    return false;
}

 if ($database_password_hash == $row['password'])){ 
    session_start();      
    $_SESSION['authenticated'] = 'Jethro Tull';
    // get the time the session started
    $_SESSION['start'] = time();
    session_regenerate_id();
    header("Location: $redirect"); exit;
} else {
    // if not verified, prepare error message
    $error = 'Invalid username or password';
}

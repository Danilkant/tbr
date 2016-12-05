<?php

    require('init.database.php');
    require('phpMailer/PHPMailerAutoLoad.php');

    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();

        $alphaLength = strlen($alphabet) - 1;

        for ($i = 0; $i < 14; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
    return implode($pass);
    }

    $data = json_decode(file_get_contents('php://input'));

    $username = $data->username;

    $name = $data->name;

    $email = $data->email;

    $password = randomPassword();

    $toSend = "";

    $cost = 10;

    // Create a random salt
    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

    // Prefix information about the hash so PHP knows how to verify it later.
    // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
    $salt = sprintf("$2a$%02d$", $cost) . $salt;

    // Hash the password with the salt
    $hash = crypt($password, $salt);

    $sth = $dbh->prepare('INSERT INTO user(username, name, email, password)
                    VALUES (:username, :name, :email, :password)');
    $sth->bindParam(':username', $username);
    $sth->bindParam(':name', $name);
    $sth->bindParam(':email', $email);
    $sth->bindParam(':password', $hash);

    $toSend = "Thank you for signing up to Tskoli Elite. Here is your temporary password: ".$password;

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
    );
    //$mail->SMTPDebug = 1;

    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = 'tskolielite@gmail.com';   
    $mail->Password = 'P@ssword8912'; 
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    


    $mail->SetFrom("tskolielite@gmail.com");
    $mail->isHTML(true);  
    $mail->Subject = "Welcome to Tskoli Elite";
    $mail->Body = $toSend;
    $mail->AddAddress($email);

    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        $sth->execute();
        echo "Message has been sent";
    }
?>
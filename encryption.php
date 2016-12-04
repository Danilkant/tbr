<?php

//Tells crypt to use blowfish for five rounds.
$Blowfish_Pre = '$2a$05$';
$Blowfish_End = '$';

//Accepted characters for Blowfish encryption
$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
$Chars_Len = 63;

//Getting date of user being registered
$mysql_date = date( 'Y-m-d' );

$Salt_Length = 21;
$salt = "";

for($i = 0; $i <= $Salt_Length; $i++)
{
    $salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
}

$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
$database_password_hash = crypt($user_password, $bcrypt_salt);
?>

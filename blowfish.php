<?php
//  Blowfish login code to verify user login password with the hashed password in database

// Make variables from login form on another page and use “include()” to get this PHP code
$user_name_from_login = $_POST[ 'login_user_name' ];
$user_password_from_login = $_POST[ 'login_password' ];

//Check users name for match in your database table of user names
// You must use a line like this “include(‘your_conection_name.php');” 
//at the top of your page to get the database connection code or add it directly to this page for this to work
$sql = "SELECT * FROM customers WHERE user_name=:login_user_name";
$query = $db->prepare( $sql );
$query->execute( array( ':login_user_name'=>$user_name_from_login ) );
$results = $query->fetchAll( PDO::FETCH_ASSOC ); 

//Get hashed password in database associated with user name and make it into a php variable
foreach( $results as $row ){ 
$database_password_hash = $row[ 'password' ];
}

//Using the Blowfish “$2a$” algorithm with a cost of  “11$” and random salt form registration  page 
// this one line converts login password to the original saved hashed so it  can be compared with the one saved in database
$user_password_rehashed = crypt($user_password_from_login, $database_password_hash);

//Now a simple comparison can be made and verified with an “if else” using the variables above
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

//Check your output to better understand process 
echo '<br>';
echo ' $user_password_from_login = ' . $user_password_from_login;
echo '<br>';
echo ' $user_password_rehashed --- = ' . $user_password_rehashed;
echo '<br>'; 
echo ' $database_password_hash ---  = ' . $database_password_hash;
echo '<br>';
?>
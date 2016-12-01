<!--PHP-->

<?php 

//Arryar búnir til 
$errors = [];
$missing = [];

//Expected fields in form
$expected = ['username', 'password'];
$required = ['username', 'password'];
//Keyrt skriftur
require './process.php';
require 'Klasar/Users.php';
require_once "connection.php";

$error = '';
if (isset($_POST['signup'])) {    
    $full_name_from_signup = filter_var(trim($_POST['fname'], FILTER_SANITIZE_STRING)); 
	$user_name_from_signup = trim($_POST['username'], FILTER_SANITIZE_STRING);
	$user_password_from_signup = trim($_POST['password'], FILTER_SANITIZE_STRING);
    $email_from_signup = trim($_POST['email'], FILTER_SANITIZE_STRING);
    
    $dbUsers = new User($connection);
    $status = $dbUsers->newUser($full_name_from_signup, $user_name_from_signup, $user_password_from_signup, $email_from_signup);

    if ($status) {
        header('Location: hello.php');
    }

    else
    {

    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <base href="/"></base>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Foundation | Welcome</title>
        <link rel="stylesheet" href="css/foundation.css" />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/form.css" />
    </head>

<body ng-app="SomeApp">

<div class="row">
  <div class="medium-6 medium-centered large-4 large-centered columns">
  <?php if($missing || $errors) { ?>
    <p class="warning">Please fix the item(s) indicated.</p>
    <?php } ?>
<form name="submitform" method="post" action"">
      <div class="row column log-in-form">
        <h4 class="text-center">Sign up</h4>

        <label for="username">Full Name
        <?php if ($missing && in_array('', $missing)) { ?>
        <span class="warning">Please enter a valid name.</span>
        <?php } ?>
          <input name="fname" type="text" id="fname" placeholder="Full Name">
        <?php if ($missing || $errors) {
            echo 'value="' . htmlentities($full_name_from_signup) . '"';
            } ?>        
        </label>

        <label for="username">Username
        <?php if ($missing && in_array('username', $missing)) { ?>
        <span class="warning">Please enter a valid username.</span>
        <?php } ?>
          <input name="username" type="text" id="username" placeholder="Username">
        <?php if ($missing || $errors) {
            echo 'value="' . htmlentities($user_name_from_signup) . '"';
            } ?>        
        </label>

        <label for="password" class="col-sm-2 control-label">
        <?php if ($missing && in_array('password', $missing)) { ?>
        <span class="warning">Please enter a valid password.</span>
        <?php } ?>
        </label>
        <label>Password
          <input name="password" type="text" id="password" placeholder="Password">
        <?php if ($missing || $errors) {
            echo 'value="' . htmlentities($user_password_from_signup) . '"';
            } ?>         
        </label>

        <label for="email" class="col-sm-2 control-label">
        <?php if ($missing && in_array('email', $missing)) { ?>
        <span class="warning">Please enter a valid email.</span>
        <?php } ?>
        </label>
        <label>Email
          <input name="email" type="text" id="email" placeholder="Email">
        <?php if ($missing || $errors) {
            echo 'value="' . htmlentities($email_from_signup) . '"';
            } ?>         
        </label>
        <!--Signup takki-->        
        <input name="signup" id="signup" type="submit" class="button">       
      </div>
</form>

  </div>
</div>

 
    <div ng-controller="MainController">
        <div ng-view></div>
    </div>
    </body>
</html>
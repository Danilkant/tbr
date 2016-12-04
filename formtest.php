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
require_once "connection.php";

$error = '';

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
<?php

if ($error) {
    echo "<p>$error</p>";
} elseif (isset($_GET['expired'])) {
    ?>
    <p>Your session has expired. Please log in again.</p>
<?php } ?>
<div class="row">
  <div class="medium-6 medium-centered large-4 large-centered columns">
  <?php if($missing || $errors) { ?>
    <p class="warning">Please fix the item(s) indicated.</p>
    <?php } ?>
<form name="submitform" method="post" action"">
      <div class="row column log-in-form">
        <h4 class="text-center">Log in with you user account</h4>
        <label for="username">Username
        <?php if ($missing && in_array('username', $missing)) { ?>
        <span class="warning">Please enter a valid username.</span>
        <?php } ?>
          <input name="username" type="text" id="username" placeholder="Username">
        </label>

        <label for="password" class="col-sm-2 control-label">
        <?php if ($missing && in_array('password', $missing)) { ?>
        <span class="warning">Please enter a valid password.</span>
        <?php } ?>
        </label>
        <label>Password
          <input name="password" type="text" id="password" placeholder="Password">
        </label>
        <input id="show-password" type="checkbox"><label for="show-password">Show password</label>
        <input name="login" id="login" type="submit" class="button">       
      </div>
</form>

  </div>
</div>

 
    <div ng-controller="MainController">
        <div ng-view></div>
    </div>
    </body>
</html>

<?php
//Arryar búnir til 
$errors = [];
$missing = [];

//Expected fields in form
$expected = ['uname', 'password'];
$required = ['uname', 'password'];

//Keyrt skriftur
require './process.php';
require "Users.php";
require_once "connection.php";

$error = '';
if (isset($_POST['send'])) {
    // use sessionm if the form has been submitted
    session_start();
    $username = trim($_POST['uname']);
    $password = trim($_POST['password']);
    // location to redirect on success, stored in a variable
    $redirect = 'http://tsuts.tskoli.is/2t/0807932279/MovieReviewer/userpage.php';
    // authentication
    require_once 'authentication.php';  
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include 'title.php'; ?>
    <title>MovieReviewer<?php echo"&#8212;{$title}";?></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-item.css" rel="stylesheet">

</head>

<body>

    <?php include "menu.php" ?>    
    <?php include "randommynd.php" ?>
    <!-- Page Content -->    
    <?php displayRandomPhotoArea(); ?>    
    <div class="container">
   
  
  <?php if($missing || $errors) { ?>
    <p class="warning">Please fix the item(s) indicated.</p>
    <?php } ?>
  <form name="submitform" method="post" action="">
  
  <div class="form-group col-md-9">
  <h3> Log in </h3>
    <label for="uname" class="col-sm-2 control-label">
    <?php if ($missing && in_array('username', $missing)) { ?>
    <span class="warning">Please enter a valid username.</span>
    <?php } ?>
    </label>
    <div class="col-sm-10">
      <input name="uname" type="uname" class="form-control" id="uname" placeholder="Username">
    </div>
  </div>

  <div class="form-group col-md-9">
    <label for="password" class="col-sm-2 control-label">
    <?php if ($missing && in_array('password', $missing)) { ?>
    <span class="warning">Please enter a valid password.</span>
    <?php } ?>
    </label>
    <div class="col-sm-10">
      <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Password">
    </div>
  </div>
  
  <div class="form-group col-md-9">
    <div class="col-sm-offset-2 col-sm-10">
      <input name="send" type="submit" class="btn btn-default">
    </div>
  </div>


</form>
</div>
    <!-- /.container -->

    <div class="container">
          
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <?php 
                    include "footer.php" 
                    ?>      
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

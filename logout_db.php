<?php
// run this script only if the logout button has been clicked
if (isset($_POST['logout'])) {
    // empty the $_SESSION array
    $_SESSION = [];
    // invalidate the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-86400, '/');
    }
    // end session and redirect
    session_destroy();

    header('Location: http://tsuts.tskoli.is/2t/0807932279/Lokaverkefni/formtest.php');
    exit;
}
?>
<form method="post" action="">
    <input name="logout" type="submit" value="Log out">
</form>

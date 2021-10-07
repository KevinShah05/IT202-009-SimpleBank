<?php
require(__DIR__. "/../../partials/nav.php");
if(!is_logged_in()){
    die(header("Location: login.php"));
}
?>

<h1>Home</h1>
<?php
if(isset($_SESSION["user"]) && isset($_SESSION["user"]["email"])){
 echo "Welcome, " . $_SESSION["user"]["email"]; 
}
else{
  echo "You're not logged in";
}
?>
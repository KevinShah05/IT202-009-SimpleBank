<?php
require(__DIR__. "/../../partials/nav.php");
if(!is_logged_in()){
    die(header("Location: login.php"));
}
?>

<ul class = "Home">
<body style= "background-color:bisque";></body>
<h1>Home</h1>
<h5>Welcome, <?php se(get_username()); ?></h5>
</ul>

<?php
require(__DIR__ . "/../../partials/flash.php");
?>
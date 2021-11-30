
<link rel="stylesheet" href="styles.css">

<?php
$domain = $_SERVER["HTTP_HOST"];
if (strpos($domain, ":")) {
    $domain = explode(":", $domain)[0];
}
session_set_cookie_params([
    "lifetime" => 60 * 60,
    "path" => "/project",
    //"domain" => $_SERVER["HTTP_HOST"] || "localhost",
    "domain" => $domain,
    "secure" => true,
    "httponly" => true,
    "samesite" => "lax"
]);
session_start();
require(__DIR__ . "/../lib/functions.php");

?>

<link rel="stylesheet" href="styles.css">
<script src="helpers.js"></script>

<nav>
<ul class="nav">
    <li><a href="home.php">Home</a></li>
    <?php if (!is_logged_in()): ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
    <?php endif; ?>

    <?php if (is_logged_in()): ?> 
        <li><a href="create_account.php">Create Account</a></li>
        <li><a href="list_account.php">View Accounts</a></li>
        <li><a href="create_transactions.php">Deposite/Withdraw</a></li>
        <li><a href="#">Transfer</a></li>      
        <li><a href="list_transactions.php">View transactions</a></li>
    <?php endif; ?>
    
    <?php if (is_logged_in()): ?>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
    <?php endif; ?>
</ul>
</nav>
<?php
$domain = $_SERVER["HTTP_HOST"];
if (strpos($domain, ":")) {
    $domain = explode(":", $domain)[0];
}
session_set_cookie_params([
    "lifetime" => 60 * 60,
    "path" => "/Project",
    //"domain" => $_SERVER["HTTP_HOST"] || "localhost",
    "domain" => $domain,
    "secure" => true,
    "httponly" => true,
    "samesite" => "lax"
]);
session_start();
require(__DIR__ . "/../lib/functions.php");

?>
<nav>
    <ul>
        <?php if (is_logged_in()) : ?>
            <li><a href="home.php">Home</a></li>
        <?php endif; ?>
        <?php if (!is_logged_in()) : ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
        <?php if (has_role("Admin")) : ?>
            <li><a href="#">Admin Stuff</a></li>
        <?php endif; ?>
        <?php if (is_logged_in()) : ?>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>
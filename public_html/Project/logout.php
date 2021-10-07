<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
setcookie("PHPSESSID", "",time()-3600);

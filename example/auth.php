<?php
session_start();
$path_to_JSONlogin = '..';
if (isset($_SESSION['login_user']) == false || empty($_SESSION['login_user'])) {
    header("Location: $path_to_JSONlogin/login.html");
} else {
	echo "\n<p><a href='$path_to_JSONlogin/logout.php'>Logout</a></p>\n";
}
?>
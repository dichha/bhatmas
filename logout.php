<?php
require_once 'model/user.php';

$user = new User();
$user->authenticate();

if (isset($_COOKIE['login'])) {

	$user->logout();
	$user->authenticate();
}

?>

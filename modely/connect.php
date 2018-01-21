<?php
$host = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'konference';
$link = mysqli_connect($host, $username, $password, $database);
if (!$link) {
    die('Nemůžete se přihlásit: ' . mysql_error());
}

?>

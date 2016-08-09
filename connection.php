<?php
ini_set('max_execution_time', 600);
ini_set('memory_limit', '1024M');

$user = "root";
$password = "root";
$database = "twitter_followers";

mysql_connect("localhost", $user, $password);
@mysql_select_db($database) or die("Unable to select database");


?>

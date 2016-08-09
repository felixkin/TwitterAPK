<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set('max_execution_time', 600);
ini_set('memory_limit', '1024M');
error_reporting(E_ALL);
require_once('database_class/MysqliDb.php');


define('CONSUMER_KEY', '');
define('CONSUMER_SECRET', '');
define('oauth_token', '');
define('oauth_token_secret', '');

$db = new MysqliDb ('localhost', 'root', 'root', 'twitter_followers');
?>

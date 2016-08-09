<?php
/* 
 * Description: This code will send direct message to the follower who are following you only.
 * 
 * */

require_once('config.php'); 
require_once('library/twitteroauth.php'); 
$connection = new Twitter;
$connect = $connection->TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, oauth_token, oauth_token_secret);
date_default_timezone_set('America/New_York');
$cols = array ("screen_name");
// comment the below line for fetching all user*/
$db->where ("account_name", 'davindernetsol');
$twitter_accounts_array = $db->get("twitter_account_followers",null,$cols); //contains an Array of all users 
  foreach ($twitter_accounts_array as $value){
      $tweetMessage = 'M '.$value['screen_name'].' Hey this is test message';
	// Check for 140 characters
	if(strlen($tweetMessage) <= 140)
	{
	    $messageResoponse = $connection->post('statuses/update', array('status' => $tweetMessage));
	}
	if($messageResoponse->id){
	    echo 'Message sent to '.$value['screen_name'].'<br>';
	} else {
	    echo 'Message failed to '.$value['screen_name'].'<br>';
	}
  }
?>

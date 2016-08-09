<?php
require_once('config.php'); //at your config file put the twitter application parameter.
require_once('library/twitteroauth.php'); //put the twitter library to your project file and give the right path here.
$connection = new Twitter;
$connect = $connection->TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, oauth_token, oauth_token_secret);
date_default_timezone_set('America/New_York');
$twitter_accounts_array = $db->get('twitter_accounts'); //contains an Array of all users 
    foreach($twitter_accounts_array as $twitter_accounts) {
	$sc_name =  $twitter_accounts['account_name'];
	//$sc_name =  'bradspencer';
	$cursor = -1;
	while ($cursor != 0) {
	 /*$ids =  (object) $array = array("ids" => array("446055631","2695142258","7.476854394825E+17","7.4768465775652E+17","7.4768302444846E+17","7.4768339863065E+17","7.47683059517E+17","7.4768115289962E+17","7.4768198217644E+17"
        ));*/
	
	    $ids = $connection->get("followers/ids", array("screen_name" => $sc_name, "cursor" => $cursor));
	    //echo count($ids->users);
	   /* echo '<pre>'; print_r($objecta); 
	    die;*/
	    $cursor = $ids->next_cursor;
	    $ids_arrays = array_chunk($ids->ids, 100);
		foreach($ids_arrays as $implode) {
		    $formatted_array = array_map(function($implode){return number_format($implode, 0, '', '');}, $implode);
		    $user_ids=implode(',', $formatted_array);
		    $results = $connection->get("users/lookup", array("user_id" => $user_ids));
		    foreach($results as $profile) {
			$db->where ("screen_name", $profile->screen_name);
			$user = $db->getOne ("twitter_account_followers");
			if(empty($user)){
			    echo $profile->id_str.'<br>';
			    echo $profile->screen_name.'<br>';
			    echo "=================================="."<br>";
			    $data = Array ("account_name" => $sc_name,
			    "screen_name" => $profile->screen_name,
			    "id_str" => $profile->id_str
			    );
			    $id = $db->insert ('twitter_account_followers', $data);	
			}
		    }
	    }
	    }
    }
?>

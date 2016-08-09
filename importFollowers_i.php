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
	/*while ($cursor != 0) {
	$ids = $connection->get("followers/ids", array("screen_name" => $sc_name, "cursor" => $cursor));
	var_dump($ids);
	$cursor = $ids->next_cursor;
	$ids_arrays = array_chunk($ids->ids, 100);
	if($ids_arrays){
	    foreach($ids_arrays as $implode) {
		$implode = number_format($implode, 0, '', '');  
		$user_ids=implode(',', $implode);
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
    }*/
    
    while ($cursor != 0) {
	$followers_array = $connection->get("followers/list", array("screen_name" => $sc_name, "cursor" => $cursor, 'count'=>200));
	$cursor = $followers_array->next_cursor;
	$followers_array = array_chunk($followers_array->users, 100);
	foreach($followers_array as $followers) {
		foreach ($followers as $value){
		    
		    $db->where ("screen_name", $value->screen_name);
		    $user = $db->getOne ("twitter_account_followers");

		    if(empty($user)){
			echo $value->id_str.'<br>';
			echo $value->screen_name.'<br>';
			echo "=================================="."<br>";
			
			$data = Array ("account_name" => $sc_name,
			"screen_name" => $value->screen_name,
			"id_str" => $value->id_str
			);
			$id = $db->insert ('twitter_account_followers', $data);	
		    }	    
		}
	    }
	}
    }
?>

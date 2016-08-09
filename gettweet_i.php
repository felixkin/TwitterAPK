<?php
include "connection.php"; //include here the connection of your database.
require_once('library/twitteroauth.php'); //put the twitter library to your project file and give the right path here.
require_once('config.php'); //at your config file put the twitter application parameter.

$connection = new Twitter;
$connect = $connection->TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, oauth_token, oauth_token_secret);

date_default_timezone_set('America/New_York');

$keyword = "#LifeHacker OR @LifeHacker";

if($keyword)
{
	$usertweets = $connection->get('search/tweets', array( 'q' => urlencode( '#'.$keyword ), 'count' => 100)); //search keywords

	if($usertweets->statuses[0]->id_str) //save the tweets or the search users to database table name: hashtag_feed
	{	
		$new = 0;		
	
		$sql = "INSERT INTO `hashtag_feed` (`feed_id`, `tweet_id`,`screen_name`,`profile_picture`,`tweet`,`create_time`,`store_time`) VALUES ";
		
		foreach($usertweets->statuses as $tweet){
			
			$tweet_time = $tweet->created_at;
			
			// I added this call which converts the Twitter time into a valid mySQL format
			$tweet_time = converttime($tweet_time);
			
			$results = mysql_num_rows(mysql_query("SELECT distinct(tweet_id) AS tweet_id FROM hashtag_feed where tweet_id=".$tweet->id_str));
			echo $results;
			if( $results == 0 ){
				
				$new = 1;
							
				$sql .= '(NULL,"'.$tweet->id_str.'","'.$tweet->user->screen_name.'","'.$tweet->user->profile_image_url.'","'.$tweet->text.'","'.$tweet_time.'",NULL),';
			}
		}
		echo $sql;
		
			if($new)
			{
				$sql = rtrim($sql,',');
				mysql_query($sql);
			}
	}
}

function converttime($twitter_datetime = '') {
	
	$mysql_format = date("Y-m-d H:i:s", strtotime($twitter_datetime));
	
	return $mysql_format;
 
}
?>
<?php

require_once 'vendor/autoload.php';
 
use Abraham\TwitterOAuth\TwitterOAuth;
 
define('CONSUMER_KEY', '9Dqjp2FwyJ9UmcfssDS7rT0Lc');
define('CONSUMER_SECRET', 'NwOU6x0Qf1lhMuf8DRzidy5i8JYtSQR8B5CkkhWoyULwu7v53p');
define('ACCESS_TOKEN', '920623806904926208-4pwyH5LaIX4ucnrSKE12yNJKAjMcE98');
define('ACCESS_TOKEN_SECRET', 'Ehb602sweAeAPymkN2vMYH9gHC1P2GMsRoXq0iq1UJzVr');
 
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
include(__DIR__.'/simple_html_dom.php');

function generateWords(){

	$words = ['ez', 'easy', 'chill', 'good', 'boy', 'nice', 'unreall', 'good', 'nice', 'myself', 'like', 'forever', 'bot', 'crypto', 'curr', 'boss', 'work', 'cash', 'money', 'boy'];

	shuffle($words);

	return implode(' ', $words);

}
	
	$links = $_POST['links'];
	$links = explode(PHP_EOL, $links);
	$ids_arr = [];
	
	foreach ($links as $url) {
	 
		$status = generateWords().' '.$url;
		$post_tweets = $connection->post('statuses/update', ['status' => $status]);

		$ids_arr[] = $post_tweets->id;
	}
	
	$tcolinks_arr = [];

	foreach ($ids_arr as $id) {

		$html = file_get_html('https://twitter.com/flagman_studio/status/'.$id);
		$title_obj = $html->find('title', 0);
		$title = $title_obj->plaintext;

		preg_match_all('/t.co\/.{1,10}/', $title, $tcolinks);

		$tcolinks_arr[] = $tcolinks[0][0];

	}

	echo '<h1>Сгенерированные ссылки</h1><br>';

	foreach ($tcolinks_arr as $temp_url) {
		echo 'https://'.$temp_url.'<br>';
	}

	echo '<br>';
	echo '<hr>';
	echo '<br>';

	$i_link = 0;
	foreach ($tcolinks_arr as $temp_url) {
		echo $links[$i_link].' - https://'.$temp_url.'<br>';
		$i_link++;
	}
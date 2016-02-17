<!-- css -->
		<link rel="stylesheet" href="http://sharetube.jp/assets/css/common/common.css" type="text/css">
		<link rel="stylesheet" href="http://sharetube.jp/assets/css/library/typicons.2.0/font/typicons.css" type="text/css">
		<link rel="stylesheet" href="http://sharetube.jp/assets/css/library/typicons.2.0.7/font/typicons.css" type="text/css">



<?php
		define('PATH', $_SERVER["DOCUMENT_ROOT"].'/');
		define('INTERNAL_PATH', str_replace('public/', '', PATH));
//------------
//create62Hash
//------------
echo PATH.'assets/img/twitter/';

function create62Hash($id, $base = 0) {
	$shuffleTable = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61);
	$asciiTable = array(65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,48,49,50,51,52,53,54,55,56,57);
	$hashTable = array();
	$i = 0;
	do {
		$hashTable[$i] = chr($asciiTable[$shuffleTable[(int)(floor($id / pow(62, $i)) + $i) % 62]]);
		$i = count($hashTable);
	} while(($base > $i) || (pow(62, $i) <= $id));


	return implode("", $hashTable);
}
echo create62Hash(147897,0);


$twitter_html = '';
//echo $twitter_html;
$subject = $twitter_html;

// スクレイピング
$subject = file_get_contents('https://twitter.com/____m_412/status/581654010295296000');
$subject = file_get_contents('https://twitter.com/tsubasa_wwsk/status/581716727727181827');
$subject = file_get_contents('https://twitter.com/Sharetube_jp/status/582179218349424640');
$subject = file_get_contents('https://twitter.com/haisekurasuta/status/571988291177742337/photo/1');









//------------
//アイコン抽出
//------------
$pattern = '/<img (.+?) js-action-profile-avatar(.+?)>/';
preg_match($pattern, $subject, $twitter_user_icon_array);
var_dump($twitter_user_icon_array);

$pattern = '/src="(.+?)"/';
preg_match($pattern, $twitter_user_icon_array[0], $twitter_user_icon_array);
var_dump($twitter_user_icon_array);
$twitter_user_icon = $twitter_user_icon_array[1];
//------------------
//ユーザーネーム抽出
//------------------
$pattern = '/<strong (.*?)show-popup-with-id(.*?)>(.*?)<\/strong>/';
preg_match($pattern, $subject, $twitter_user_name_array);
var_dump($twitter_user_name_array);
$twitter_user_name = $twitter_user_name_array[3];
//--------------
//ユーザーid抽出
//--------------
$pattern = '/<b>(.+?)<\/b>/';
preg_match($pattern, $subject, $twitter_user_id_array);
var_dump($twitter_user_id_array);
$twitter_user_id = $twitter_user_id_array[1];

//------------------
//ツイートタイム抽出
//------------------
$pattern = '/data-time="(.+?)"/';
preg_match($pattern, $subject, $twitter_tweet_time_array);
var_dump($twitter_tweet_time_array);
$twitter_tweet_time = (int)$twitter_tweet_time_array[1];
var_dump(date('Y年m月d日 H:i:s'  ,$twitter_tweet_time));
$twitter_tweet_time = date('Y年m月d日 H:i:s'  ,$twitter_tweet_time);

//--------------------
//ツイートテキスト抽出
//--------------------
$pattern = '/<p(.+?)tweet-text">(.+?)<\/p>/';
$pattern = '/<p(.+?)tweet-text(.+?)>(.+?)<\/p>/';

preg_match($pattern, $subject, $twitter_tweet_text_array);
var_dump($twitter_tweet_text_array);
$twitter_tweet_text = $twitter_tweet_text_array[3];
//-------------------------------
//ツイートRT数 & お気に入り数抽出
//-------------------------------
$pattern = '/data-tweet-stat-count="(.+?)"/';
preg_match_all($pattern, $subject, $twitter_tweet_retweet_fav_array);
var_dump($twitter_tweet_retweet_fav_array);
$twitter_tweet_retweet  = $twitter_tweet_retweet_fav_array[1][0];
$twitter_tweet_fav      = $twitter_tweet_retweet_fav_array[1][1];
//--------------------------
//ツイートプライマリーid取得
//--------------------------
$pattern = '/data-tweet-id="(.+?)"/';
preg_match($pattern, $subject, $twitter_tweet_id_array);
var_dump($twitter_tweet_id_array);
$twitter_tweet_id = $twitter_tweet_id_array[1];
//----------------
//画像メディア取得
//----------------
$pattern = '/<img (.+?)media(.+?)>/';
preg_match_all($pattern, $subject, $twitter_tweet_image_media_array);
var_dump($twitter_tweet_image_media_array);
$pattern = '/src="(.+?)"/';
echo 'あーーーーーーーー';
foreach($twitter_tweet_image_media_array[0] as $key => $value) {
	preg_match($pattern, $value, $twitter_tweet_image_media_preg_match_array);
$twitter_tweet_image_media_foreach_array[$key] = $twitter_tweet_image_media_preg_match_array[1];
}
var_dump($twitter_tweet_image_media_foreach_array);



//
//
//
$tweet_data_array = array();
$tweet_data_array['icon']        = $twitter_user_icon;
$tweet_data_array['name']        = $twitter_user_name;
$tweet_data_array['id']          = $twitter_user_id;
$tweet_data_array['time']        = $twitter_tweet_time;
$tweet_data_array['text']        = $twitter_tweet_text;
$tweet_data_array['retweet']     = $twitter_tweet_retweet;
$tweet_data_array['fav']         = $twitter_tweet_fav;
$tweet_data_array['tweet_id']    = $twitter_tweet_id;
$tweet_data_array['image_media'] = $twitter_tweet_image_media_foreach_array;

var_dump($tweet_data_array);
//
//
//
$twitter_url = 'https://twitter.com/';

//
//
//
foreach($tweet_data_array["image_media"] as $key => $value) {
	var_dump($value);
		// 拡張子取得
		$type_str = substr($value, strrpos($value, '.') + 1);
		// 置換（jpeg→jpg）
		$type_str = str_replace("jpeg","jpg", $type_str);
		var_dump($type_str);
		DB::query("
			INSERT INTO twitter_media (
				sharetube_in, 
				extension, 
			)
			VALUES (
				'mtoksuy', 
				'jpg'
			)")->execute();
		var_dump($type_str);
//		create62Hash(147897,0)
}

/*
		// path取得
		$res = DB::query("
			SELECT COUNT(primary_id)
			FROM ".$article_type."")->execute();
*/








/*
$url = 'https://pbs.twimg.com/media/B-6vF4_UQAARBg3.jpg';
$curl_session = curl_init(); // cURL セッション初期化
curl_setopt($curl_session, CURLOPT_URL, $url); // 取得する URL 。curl_init() でセッションを 初期化する際に指定することも可能です。 
curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true); // TRUE を設定すると、curl_exec() の返り値を 文字列で返します。通常はデータを直接出力します。
$data = curl_exec($curl_session); // cURL セッションを実行する

//file_put_contents(PATH.'assets/img/twitter/logo.jpg',$data);
curl_close(); // cURL セッションを閉じる
*/










$html = '
<div class="tweet">
	<div class="tweet_content">		
		<div class="tweet_content_icon">
			<a href="'.$twitter_url.$tweet_data_array["id"].'" target="_blank">
				<img src="'.$tweet_data_array['icon'].'" width="48" height="48">
			</a>
		</div>
		<div class="tweet_content_name">
			<a href="'.$twitter_url.$tweet_data_array["id"].'" target="_blank">
				<b>'.$tweet_data_array['name'].'</b>
				<span>@'.$tweet_data_array['id'].'</span>
			</a>
		</div>
		<div class="tweet_content_text">
			'.$tweet_data_array['text'].'
		</div>
		<div class="tweet_content_action clearfix">
			<div class="tweet_content_action_reply">
				<a data-scribe="element:reply" title="返信" class="reply-action web-intent" href="https://twitter.com/intent/tweet?in_reply_to='.$tweet_data_array["tweet_id"].'" data-tw-params="true">
					<span class="typcn typcn-arrow-back"></span>
				</a>
			</div>
			<div class="tweet_content_action_retweet">
				<a data-scribe="element:retweet" title="リツイート" class="retweet-action web-intent" href="https://twitter.com/intent/retweet?tweet_id='.$tweet_data_array["tweet_id"].'" data-tw-params="true">
					<span class="typcn typcn-arrow-repeat">'.$tweet_data_array["retweet"].'</span>
				</a>
			</div>
			<div class="tweet_content_action_fav">
				<a data-scribe="element:favorite" title="お気に入り" class="favorite-action web-intent" href="https://twitter.com/intent/favorite?tweet_id='.$tweet_data_array["tweet_id"].'">
					<span class="typcn typcn-star-full-outline">'.$tweet_data_array["fav"].'</span>
				</a>
			</div>
			<div class="tweet_content_time">
				<a href="'.$twitter_url.$tweet_data_array["id"].'/status/'.$tweet_data_array["tweet_id"].'" target="_blank">
					'.$tweet_data_array["time"].'
				</a>
			</div>
		</div>
	</div>
</div>';

echo $html;
var_dump($html);














?>
<!-- Twitterプラグイン -->
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
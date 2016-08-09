<?php 

/**
 * Twitterスクレイピング関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Twitterscraping_Mirror_Basis extends Model {
	//------------
	//create62Hash
	//------------
	static function create62Hash($id, $base = 0) {
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
	//---------------------
	//Twitterスクレイピング
	//---------------------
	static function Twitter_scraping($tweet_url) {
		$twitter_url = 'https://twitter.com/';
		// スクレイピング
		$subject = file_get_contents($tweet_url);
		// utf-8をUTF-8に置換
		$subject = str_replace('<meta charset="UTF-8">', '<meta charset="UTF-8"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">', $subject);
		$subject = str_replace('<meta charset="utf-8">', '<meta charset="utf-8"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">', $subject);
		// DOMクラス生成
		$dom = new DOMDocument('1.0', 'UTF-8');
		// 文字列から HTML を読み込む
		@$dom->loadHTML($subject);
/*
    DOMXPath::__construct          — 新しい DOMXPath オブジェクトを作成する
    DOMXPath::evaluate             — 与えられた XPath 式を評価し、可能であれば結果を返す
    DOMXPath::query                — 与えられた XPath 式を評価する
    DOMXPath::registerNamespace    — DOMXPath オブジェクトの名前空間を登録する
    DOMXPath::registerPhpFunctions — PHP の関数を XPath 関数として登録する
			が使えるようになる。
*/
		$xpath = new DOMXPath($dom);
		// DOMXPath オブジェクトの名前空間を登録する
		$xpath->registerNamespace("php", "http://php.net/xpath");
		// PHP の関数を XPath 関数として登録する
		$xpath->registerPHPFunctions();
		// ・主コンテンツのみ取得(重要)
		$subject = $xpath->query('//div[@class="permalink-inner permalink-tweet-container"]')->item(0);

		// HTMLとして取り出す
		$subject = Model_Login_Twitterscraping_Basis::getInnerHtml($subject);
		// デコード
		$subject =  htmlspecialchars_decode($subject, ENT_QUOTES);
//		print($subject);

///////////////////////////////////////////////////
//マルチ画像メディア取得 & リツイートのツイート判定
///////////////////////////////////////////////////
		/*
			マニュアル
			http://simplehtmldom.sourceforge.net/manual.htm

			解決しました
			PHP Simple HTML DOM Parserで改行コードが削除される問題
			http://matomerge.com/simple-html-dom-parser-trouble/
			
			str_get_htmlの場合()
			str_get_html($article_html, true, true, DEFAULT_TARGET_CHARSET, false);
			
			file_get_htmlの場合()
			file_get_html($file, false, null, -1, -1, true, true, DEFAULT_TARGET_CHARSET, false);
		*/


/*
削除系
http://sato-san.hatenadiary.jp/entry/2013/05/06/155919
*/

		// simple_html_domライブラリ読み込み
		require_once INTERNAL_PATH.'fuel/app/classes/library/simplehtmldom_1_5/simple_html_dom.php';
		// URLから
		$simple_html_dom_object = file_get_html($tweet_url);

/*
		// コンテンツ取得
		foreach($simple_html_dom_object->find('.permalink-tweet-container') as $list) {
			 $permalink_tweet_container_html .= $list->outertext;
		}
*/
		// コンテンツ取得
		foreach($simple_html_dom_object->find('.tweet-text') as $list) {
			 $permalink_tweet_container_html .= $list->outertext;
		}
//		var_dump($permalink_tweet_container_html);




		// permalink_tweet_container_object生成
		$permalink_tweet_container_object = str_get_html($permalink_tweet_container_html, true, true, DEFAULT_TARGET_CHARSET, false);
		// リツイートコンテンツ取得
		foreach($permalink_tweet_container_object->find('.QuoteTweet') as $list) {
			 $QuoteTweet_html .= $list->outertext;
		}
//		var_dump($QuoteTweet_html);
		// リツイートのツイートだった場合
		if($QuoteTweet_html) {
			// リツイート・ツイートチェック
			$retweet_tweet_check = true;
			// とりあえず何もしない 2015.09.03 松岡
		}
			// 通常の場合
			else {
				// リツイート・ツイートチェック
				$retweet_tweet_check = false;
				// multi-photos取得
/*
				foreach($permalink_tweet_container_object->find('.multi-photos') as $list) {
					$multi_photos_html .= $list->outertext;
				}
*/
				foreach($permalink_tweet_container_object->find('.OldMedia-quadPhoto') as $list) {
					$multi_photos_html .= $list->outertext;
				}
				foreach($permalink_tweet_container_object->find('.OldMedia-doublePhoto') as $list) {
					$multi_photos_html .= $list->outertext;
				}
			}
		//開放
		$simple_html_dom_object->clear();
		$permalink_tweet_container_object->clear();
		// 変数破棄
		unset($simple_html_dom_object);
		unset($permalink_tweet_container_object);


///////////////////////////////



















		//////////////
		//アイコン抽出
		//////////////
		$twitter_tweet_icon_media_foreach_array = array();
		$pattern = '/<img (.+?) js-action-profile-avatar(.+?)>/';
		preg_match($pattern, $subject, $twitter_user_icon_array);
//		var_dump($twitter_user_icon_array);
		$pattern = '/src="(.+?)"/';
		preg_match($pattern, $twitter_user_icon_array[0], $twitter_user_icon_array);
//		var_dump($twitter_user_icon_array);
		$twitter_user_icon       = $twitter_user_icon_array[1];
		array_push($twitter_tweet_icon_media_foreach_array, $twitter_user_icon);
//		var_dump($twitter_tweet_icon_media_foreach_array);





















		////////////////////
		//ユーザーネーム抽出
		////////////////////
/*
var.1

		$pattern = '/認証済みアカウント/';
		$review = preg_match($pattern, $subject, $twitter_user_name_array);
//		var_dump($review);
//		var_dump($twitter_user_name_array);

		// 認証済みアカウント
		if($review) {
//			var_dump($review);
			$pattern = '/<strong (.+?)show-popup-with-id(.+?)>(.+?)<span/';
			preg_match($pattern, $subject, $twitter_user_name_array);
//			var_dump($twitter_user_name_array);
			$twitter_user_name = $twitter_user_name_array[3];
		}
			// 一般のアカウント
			else {
				$pattern = '/<strong (.+?)show-popup-with-id(.+?)>(.+?)<\/strong>/';
				preg_match($pattern, $subject, $twitter_user_name_array);
//				var_dump($twitter_user_name_array);
				$twitter_user_name = $twitter_user_name_array[3];
			}
*/

/*
var.2
		$pattern = '/<meta(.+?)og:title(.+?)>/';
		$pattern = '/content="(.+?)はTwitterを使っています"/';
		$review = preg_match($pattern, $subject, $twitter_user_name_array);
//		var_dump($twitter_user_name_array);
		$twitter_user_name = str_replace('さん', '', $twitter_user_name_array[1]);
//		var_dump($twitter_user_name);
*/
		$pattern = '/data-name="(.+?)"/';
		$review = preg_match($pattern, $subject, $twitter_user_name_array);
		$twitter_user_name = $twitter_user_name_array[1];

		////////////////
		//ユーザーid抽出
		////////////////
		$pattern = '/<b>(.+?)<\/b>/';
		preg_match($pattern, $subject, $twitter_user_id_array);
//		var_dump($twitter_user_id_array);
		$twitter_user_id = $twitter_user_id_array[1];	
		////////////////////
		//ツイートタイム抽出
		////////////////////
		$pattern = '/data-time="(.+?)"/';
		preg_match($pattern, $subject, $twitter_tweet_time_array);
//		var_dump($twitter_tweet_time_array);
		$twitter_tweet_time = (int)$twitter_tweet_time_array[1];
//		var_dump(date('Y年m月d日 H:i:s'  ,$twitter_tweet_time));
		$twitter_tweet_time = date('Y年m月d日 H:i:s'  ,$twitter_tweet_time);
		//////////////////////
		//ツイートテキスト抽出
		//////////////////////
/*
var.1
		$pattern = '/<p(.+?)tweet-text">(.+?)<\/p>/';
		$pattern = '/<p(.+?)tweet-text(.+?)>(.+?)<\/p>/';
		preg_match($pattern, $subject, $twitter_tweet_text_array);
//		var_dump($twitter_tweet_text_array);
		$twitter_tweet_text = $twitter_tweet_text_array[3];
		$twitter_tweet_text = Model_Login_Twitterscraping_Basis::hash_tag_scan_replace($twitter_tweet_text);
*/

//		var.2
		// meta追加
		$subject .= '<meta charset="UTF-8"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
		// DOMクラス生成
		$dom_text = new DOMDocument('1.0', 'UTF-8');
		// 文字列から HTML を読み込む
		@$dom_text->loadHTML($subject);
		$xpath_text = new DOMXPath($dom_text);
		// DOMXPath オブジェクトの名前空間を登録する
		$xpath_text->registerNamespace("php", "http://php.net/xpath");
		// PHP の関数を XPath 関数として登録する
		$xpath_text->registerPHPFunctions();
		// (重要) Twitterが仕様をころころ変えるので悩んでいるところ
//		$twitter_tweet_text = $xpath_text->query('//p[@class="js-tweet-text tweet-text"]')->item(0);
//		$twitter_tweet_text = $xpath_text->query('//p[@class="TweetTextSize TweetTextSize--max js-tweet-text tweet-text"]')->item(0);
		$twitter_tweet_text = $xpath_text->query('//p[@class="TweetTextSize TweetTextSize--26px js-tweet-text tweet-text"]')->item(0);
/*

 <p class="TweetTextSize TweetTextSize--28px js-tweet-text tweet-text" lang="ja" data-aria-label-part="0">これでサイコロ作ったらネタになるｗ&#10;…&#10;これぞ「ヘビーメタル」、手のひらサイズで重量1kgもあるタングステン立方体「Forge Solid」&#10;<a href="http://t.co/sxGyTrn0bj" rel="nofollow" dir="ltr" data-expanded-url="http://gigazine.net/news/20150409-forge-solid/" class="twitter-timeline-link" target="_blank" title="http://gigazine.net/news/20150409-forge-solid/" ><span class="tco-ellipsis"></span><span class="invisible">http://</span><span class="js-display-url">gigazine.net/news/20150409-</span><span class="invisible">forge-solid/</span><span class="tco-ellipsis"><span class="invisible">&nbsp;</span>…</span></a></p>


<p lang="ja" data-aria-label-part="0" class="TweetTextSize TweetTextSize--max js-tweet-text tweet-text">西本願寺では、亀裂や穴を補強する為
「埋め木」という方法で修繕がなされている。此れがまた大工の小粋な遊び心満載でして。私はすっかり西本願寺の虜です
全く知らなかったけれど、お爺ちゃんが近づいて来て教えてくれた。一期一会の出逢いに感謝よ <a dir="ltr" data-pre-embedded="true" class="twitter-timeline-link u-hidden" href="http://t.co/eaEHg07ycE">pic.twitter.com/eaEHg07ycE</a></p>
*/

		// HTMLとして取り出す
		$twitter_tweet_text = Model_Login_Twitterscraping_Basis::getInnerHtml($twitter_tweet_text);
		// デコード
		$twitter_tweet_text =  htmlspecialchars_decode($twitter_tweet_text, ENT_QUOTES);


		// ハッシュタグリンク付け
		$twitter_tweet_text = Model_Login_Twitterscraping_Basis::hash_tag_scan_replace($twitter_tweet_text);
		// リプライ系のアカウントを走査し、リンク付けする
		$twitter_tweet_text = Model_Login_Twitterscraping_Basis::replay_link_create($twitter_tweet_text);
		// 絵文字画像から絵文字を抽出してtextに挿入
		$twitter_tweet_text = Model_Login_Twitterscraping_Basis::convert_pictogram_in_text($twitter_tweet_text);

































		/////////////////////////////////
		//ツイートRT数 & お気に入り数抽出
		/////////////////////////////////
		$pattern = '/data-tweet-stat-count="(.+?)"/';
		preg_match_all($pattern, $subject, $twitter_tweet_retweet_fav_array);
//		var_dump($twitter_tweet_retweet_fav_array);
		$twitter_tweet_retweet  = $twitter_tweet_retweet_fav_array[1][0];
		$twitter_tweet_fav      = $twitter_tweet_retweet_fav_array[1][1];
		////////////////////////////
		//ツイートプライマリーid取得
		////////////////////////////
		$pattern = '/data-tweet-id="(.+?)"/';
		preg_match($pattern, $subject, $twitter_tweet_id_array);
//		var_dump($twitter_tweet_id_array);
		$twitter_tweet_id = $twitter_tweet_id_array[1];
		//////////////////
		//画像メディア取得
		//////////////////
		$pattern = '/<img (.+?)\/media\/(.+?)>/';
		$pattern = '/data-image-url="(.+?)"/';
		preg_match_all($pattern, $subject, $twitter_tweet_image_media_array);
//		echo($subject);
//		var_dump($twitter_tweet_image_media_array);
		foreach($twitter_tweet_image_media_array[0] as $key => $value) {
			preg_match($pattern, $value, $twitter_tweet_image_media_preg_match_array);
//			var_dump($twitter_tweet_image_media_preg_match_array);
			$twitter_tweet_image_media_foreach_array[$key] = $twitter_tweet_image_media_preg_match_array[1];
		}

		// マルチメディアだった場合
		if($multi_photos_html) {
			$pattern = '/data-url="(.+?)"/';
			$pattern = '/data-image-url="(.+?)"/';
			preg_match_all($pattern, $multi_photos_html, $twitter_tweet_image_media_array);
//			var_dump($twitter_tweet_image_media_array);
			foreach($twitter_tweet_image_media_array[1] as $key => $value) {
				$twitter_tweet_image_media_foreach_array[$key] = $value;
			}
		}
		// リツイート・ツイートだった場合破棄する
		if($retweet_tweet_check) {
			$twitter_tweet_image_media_foreach_array = '';
		}
//		var_dump($twitter_tweet_image_media_foreach_array);

		/////////////////
		//gifメディア取得
		/////////////////
//		echo ($subject);
		$pattern = '/<video (.+?)animated-gif(.+?)<\/video>/';
		$pattern = '/<video(.+?)animated-gif(.+?)>/';
		$pattern = '/video-src="(.+?)"/';
		preg_match_all($pattern, $subject, $gif_video_array);
		$pattern = '/src="(.+?)"/';
		foreach($gif_video_array as $key => $value) {
			if(preg_match($pattern, $value[0], $gif_video_preg_match_array)) {
				$twitter_tweet_gif_media_foreach_array[$key] = $gif_video_preg_match_array[1];
			}
		}
		/////////////////////////////
		//gifメディアのサムネイル取得
		/////////////////////////////
		if($twitter_tweet_gif_media_foreach_array) {
			$pattern = '/poster="(.+?)"/';
			preg_match($pattern, $subject, $gif_video_thumbnail_array);
			$gif_video_thumbnail_array = array($gif_video_thumbnail_array[1]);
		} 
		///////////////////
		//videoメディア取得
		///////////////////
		$pattern = '/data-full-card-iframe-url="(.+?)"/';
		if(preg_match($pattern, $subject, $video_array)) {
//			var_dump($video_array);
//			var_dump($twitter_url.$video_array[1]);
			$video_subject = file_get_contents($twitter_url.$video_array[1]);
//			var_dump($video_subject);
			$pattern = '/data-player-config="(.+?)"/';
			$pattern = '/https:(.+?)video\.twimg\.com/';
			$pattern = '/video\.twimg\.com(.+?)(\.mp4|\.webm)/';
			preg_match($pattern, $video_subject, $video_array);
//			var_dump($video_array);
			$video = $video_array[0];
			// 置換(\削除)
			$video = str_replace('\\', '', $video);
			$video = 'https://'.$video;
//			var_dump($video);
			$twitter_tweet_video_media_foreach_array = array($video);
			// var.1.1 url含んだ 記事カード があるとifaremがあって引っかかる・・・ 応急処置
			if(!$video_array) {
//				var_dump($video_array);
				$twitter_tweet_video_media_foreach_array = null;
			}
		}
		///////////////////////////////
		//videoメディアのサムネイル取得
		///////////////////////////////
		if($twitter_tweet_video_media_foreach_array) {
			$pattern = '/data-card-url="(.+?)"/';
			preg_match($pattern, $subject, $video_thumbnail_array);
			$video_thumbnail_array =  array($video_thumbnail_array[1]);
		}
		///////////////////////
		//$tweet_data_array生成
		///////////////////////
		$tweet_data_array = array();
		$tweet_data_array['icon']                  = $twitter_user_icon;
		$tweet_data_array['name']                  = $twitter_user_name;
		$tweet_data_array['id']                    = $twitter_user_id;
		$tweet_data_array['time']                  = $twitter_tweet_time;
		$tweet_data_array['text']                  = $twitter_tweet_text;
		$tweet_data_array['retweet']               = $twitter_tweet_retweet;
		$tweet_data_array['fav']                   = $twitter_tweet_fav;
		$tweet_data_array['tweet_id']              = $twitter_tweet_id;
		$tweet_data_array['icon_media']            = $twitter_tweet_icon_media_foreach_array;
		$tweet_data_array['image_media']           = $twitter_tweet_image_media_foreach_array;
		$tweet_data_array['gif_media']             = $twitter_tweet_gif_media_foreach_array;
		$tweet_data_array['video_media']           = $twitter_tweet_video_media_foreach_array;
		$tweet_data_array['video_media_thumbnail'] = $video_thumbnail_array;
		$tweet_data_array['gif_media_thumbnail']   = $gif_video_thumbnail_array;

//		var_dump($tweet_data_array);
//		var_dump($twitter_user_icon_array);
//		var_dump($twitter_tweet_image_media_foreach_array);

		///////////////////////////////////////////////////////
		//アイコン画像メディアデータベース登録&ファイル書き込み
		///////////////////////////////////////////////////////
		$image_media_array	 = Model_Login_Twitterscraping_Basis::media_run($tweet_data_array, 'icon_media');
		$tweet_data_array["icon"] = $image_media_array[0];
//		 var_dump($image_media_array);

		///////////////////////////////////////////////
		//画像メディアデータベース登録&ファイル書き込み
		///////////////////////////////////////////////
		$image_media_array	 = Model_Login_Twitterscraping_Basis::media_run($tweet_data_array, 'image_media');
		$tweet_data_array["image_media_run"] = $image_media_array;
//		 var_dump($image_media_array);

		//////////////////////////////////////////////
		//gifメディアデータベース登録&ファイル書き込み
		//////////////////////////////////////////////
		$image_media_array	 = Model_Login_Twitterscraping_Basis::media_run($tweet_data_array, 'gif_media');
		$tweet_data_array["gif_media_run"] = $image_media_array;

		/////////////////////////////////////////////////////////
		//gifメディア(thumbnail)データベース登録&ファイル書き込み
		/////////////////////////////////////////////////////////
		$image_media_array	 = Model_Login_Twitterscraping_Basis::media_run($tweet_data_array, 'gif_media_thumbnail');
		$tweet_data_array["gif_media_thumbnail_run"] = $image_media_array;

		////////////////////////////////////////////////
		//videoメディアデータベース登録&ファイル書き込み
		////////////////////////////////////////////////
		$image_media_array	 = Model_Login_Twitterscraping_Basis::media_run($tweet_data_array, 'video_media');
		$tweet_data_array["video_media_run"] = $image_media_array;

		///////////////////////////////////////////////////////////
		//videoメディア(thumbnail)データベース登録&ファイル書き込み
		///////////////////////////////////////////////////////////
		$image_media_array	 = Model_Login_Twitterscraping_Basis::media_run($tweet_data_array, 'video_media_thumbnail');
		$tweet_data_array["video_media_thumbnail_run"] = $image_media_array;
//		var_dump($tweet_data_array);

		return $tweet_data_array;
	}
	//---------------------------------------------
	//アイコン画像データベース登録&ファイル書き込み
	//---------------------------------------------
	static function icon_run() {
		// media_runに統合 2015.05.30 松岡
	}
	//---------------------------------------------
	//画像メディアデータベース登録&ファイル書き込み
	//---------------------------------------------
	static function media_run($tweet_data_array, $media_type = 'image_media') {
		$image_media_array = array();
		// 画像メディア分を実行
		foreach($tweet_data_array[$media_type] as $key => $value) {
			// 拡張子取得
			$type_str = substr($value, strrpos($value, '.') + 1);
			// 置換（jpeg→jpg）
			$extension = str_replace("jpeg","jpg", $type_str);
		
			// データベース登録
			$res = DB::query("
				INSERT INTO twitter_media (
					sharetube_id, 
					extension
				)
				VALUES (
					'".$_SESSION["sharetube_id"]."', 
					'".$extension."'
				)")->execute();
			// ハッシュ取得
			$create62Hash = Model_Login_Twitterscraping_Basis::create62Hash($res[0], 0);
			// データベース変更
			DB::query("
				UPDATE twitter_media
					SET media_name = '".$res[0]."_".$create62Hash."'
					WHERE primary_id = ".$res[0]."")->execute();

			// ファイルネーム
			$file_name = $res[0].'_'.$create62Hash.'.'.$extension;
			$curl_session = curl_init(); // cURL セッション初期化
			curl_setopt($curl_session, CURLOPT_URL, $value); // 取得する URL 。curl_init() でセッションを 初期化する際に指定することも可能です。 
			curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true); // TRUE を設定すると、curl_exec() の返り値を 文字列で返します。通常はデータを直接出力します。
			$data = curl_exec($curl_session); // cURL セッションを実行する
//			var_dump($data);
			// データを指定した場所に書き込み(重要)
			file_put_contents(PATH.'assets/img/twitter/'.$file_name, $data);
			curl_close(); // cURL セッションを閉じる
			// データベース登録&ファイル書き込みした画像array
			$image_media_array[$key] = $file_name;
		} // foreach($tweet_data_array["image_media"] as $key => $value) {
//		var_dump($image_media_array);
		return $image_media_array;
	}
	//-----------------------------------
	//ハッシュタグがあるかないか走査&置換
	//-----------------------------------
	static function hash_tag_scan_replace($twitter_tweet_text) {
		$twitter_url = 'https://twitter.com/';
		$pattern      = 'href="/hashtag/';
		$replace_text = 'href="'.$twitter_url.'hashtag/';
		$twitter_tweet_text = str_replace($pattern, $replace_text, $twitter_tweet_text);
		return $twitter_tweet_text;
	}
	//----------------------------------------------
	//リプライ系のアカウントを走査し、リンク付けする
	//----------------------------------------------
	static function replay_link_create($twitter_tweet_text) {
		$twitter_url = 'https://twitter.com';
		$pattern_1 = '/<a(.+?)class="(?*)twitter-atreply(?*)"(.+?)<\/a>/';
		$pattern_1 = '/<a(.+?)class="twitter-atreply(.+?)"(.+?)<\/a>/';
		$pattern_2 = '/href="(.+?)"/';
//var_dump($twitter_tweet_text);
/*
<a href="/0v0oooaoisan" class="twitter-atreply pretty-link js-nav" dir="ltr"><s>@</s><b>0v0oooaoisan</b></a>

<a href="/rkrn___415" class="twitter-atreply pretty-link js-nav" dir="ltr"><s>@</s><b>rkrn___415</b></a> スーパーの仕事大変なのにお客様の要望も応えるとか凄いですね
イラスト的に
*/
		// リプ相手検索
		preg_match_all($pattern_1, $twitter_tweet_text, $replay_link_create_array);
//		var_dump($replay_link_create_array);

		// 見つかった分回す
		foreach($replay_link_create_array[0] as $key => $value) {
			// 完成文
			$replace_text = 'href="'.$twitter_url.'';
			// hretを抜く
			preg_match($pattern_2, $value, $replay_link_create_array);
			// 抜いたところを置換して完成文を差し込む
			$twitter_tweet_text = str_replace($replay_link_create_array[0], 'href="'.$twitter_url.$replay_link_create_array[1].'"', $twitter_tweet_text);
		}
		return $twitter_tweet_text;
	}
		//--------------------------------
		//絵文字画像を絵文字テキストに変換
		//--------------------------------
/*
iPhone絵文字リストツイート表
https://twitter.com/Sharetube_jp/status/691823389284106242

https://twitter.com/Sharetube_jp/status/691823445668163584

https://twitter.com/Sharetube_jp/status/691823471823818752

https://twitter.com/Sharetube_jp/status/691823586147958789

https://twitter.com/Sharetube_jp/status/691823607081738243

https://twitter.com/Sharetube_jp/status/691823682621198336

https://twitter.com/Sharetube_jp/status/691823720734838784

https://twitter.com/Sharetube_jp/status/691823751843991552

https://twitter.com/Sharetube_jp/status/691823768809951232

https://twitter.com/Sharetube_jp/status/691823827215597568

https://twitter.com/Sharetube_jp/status/691823846341623812

https://twitter.com/Sharetube_jp/status/691823926742237185

https://twitter.com/Sharetube_jp/status/691823957440339968

https://twitter.com/Sharetube_jp/status/691824007553929216

https://twitter.com/Sharetube_jp/status/691824022661795843

ほとんどが3〜4byteだが、国旗が8バイト

*/
		public static function convert_pictogram_in_text($twitter_tweet_text) {
			$pattern = '/<img class="twitter-emoji"(.*?)alt="(.*?)"(.*?)>/'; // 旧
			$pattern = '/<img class="Emoji Emoji--forText"(.*?)alt="(.*?)"(.*?)>/'; // 新
			preg_match_all($pattern, $twitter_tweet_text, $twitter_tweet_text_array);
			foreach($twitter_tweet_text_array[0] as $key => $value) {
			$emoji_strlen	= strlen($twitter_tweet_text_array[2][$key]);
			// テスト
			$tweet_text_array[2][$key] = mb_convert_encoding($tweet_text_array[2][$key], "UTF-8");
//			var_dump($emoji_strlen);
//			var_dump($twitter_tweet_text_array[2][$key]);
			// 絵文字は3~4バイトなのでそれ以降のデータを削除する

			if($emoji_strlen == 8) {
					$emoji_text = $twitter_tweet_text_array[2][$key];
			}
				else if($emoji_strlen > 4) {
//					$emoji_text = substr($twitter_tweet_text_array[2][$key], 0, 4);
						$emoji_text = $twitter_tweet_text_array[2][$key];
//					var_dump($emoji_text);
				}
					else {
						$emoji_text = $twitter_tweet_text_array[2][$key];
					}
//					var_dump($emoji_text);
				// 画像の絵文字をテキストの絵文字に差し替える
				$twitter_tweet_text = str_replace($value, $emoji_text, $twitter_tweet_text);
			}
/*
2016.01.26 iPhone絵文字は完璧だが、Android絵文字が未だ謎である 松岡
AndroidはShift-JISらしい





<img class="Emoji Emoji--forText" src="https://abs.twimg.com/emoji/v2/72x72/1f64c-1f3fb.png" draggable="false" alt="🙌🏻" title="バンザイする人 (明るい肌色)" aria-label="Emoji: バンザイする人 (明るい肌色)">

<img class="Emoji Emoji--forText" src="https://abs.twimg.com/emoji/v2/72x72/263a.png" draggable="false" alt="☺️" title="笑顔" aria-label="Emoji: 笑顔">

*/


			return $twitter_tweet_text;
		}
	//----------------------
	//HTMLとして取り出す関数
	//----------------------
	static function getInnerHtml($node) {
		$children = $node->childNodes;
		$html = '';
		foreach($children as $child) {
		    $html .= $node->ownerDocument->saveHTML($child);
		}
		return $html;
	}
	//----------------------------
	//オブジェクトを配列で返す関数
	//----------------------------
	function obj_to_arr($obj) {
	 if (is_object($obj)) {
	      $obj = get_object_vars($obj);
	   }
	   if (is_array($obj)) {
	       foreach ($obj as $key => $row) {
	         $obj[$key] = obj_to_arr($row);
	      }
	   }
	   return $obj;
	}
}

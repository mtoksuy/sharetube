<?php
/*
* Ajax まとめ URLのデータ取得コントローラー
* 
* 
* 
*/
class Controller_Ajax_Matome_linkdataget extends Controller {
	// アクション
	public function action_index() {
		// 変数
		$url = $_POST['url'];
		// 偽装オプション
		$options = array(
		  'http' => array(
		    'method' => 'GET',
		    'header' => 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:50.0) Gecko/20100101 Firefox/50.0',
		  ),
		);
		// 偽装コンテキスト作成
		$context = stream_context_create($options);
		// スクレイピング
		$subject = file_get_contents($url, false, $context);

		/********************************************
		file_get_contents()で文字化けさせない方法
		http://gokexn.blog.fc2.com/blog-entry-91.html
		*********************************************/
		$min_pos = 99999999999999;//十分に大きな数字
		$from_encoding ='UTF-8';//デフォルト
		foreach(array('UTF-8','SJIS', 'Shift_JIS', 'EUC-JP','ASCII','JIS','ISO-2022-JP') as $charcode){
		  if($min_pos > stripos($subject,$charcode,0) && stripos($subject,$charcode,0)>0){
		    $min_pos =  stripos($subject,$charcode,0);
		    $from_encoding = $charcode;
		  }
		}
		// 文字列エンコードコンバート
		$subject = mb_convert_encoding($subject, "utf8", $from_encoding);

		//////////////
		//タイトル取得
		//////////////
		$pattern = '/<title>(.+?)<\/title>|&lt;title&gt;(.+?)&lt;\/title&gt;/si';
		$pattern = '/<title>(.+?)<\/title>|&lt;title&gt;(.+?)&lt;\/title&gt;|<title id=\"pageTitle\">(.+?)<\/title>/si';
		// title検索
		preg_match($pattern, $subject, $title_array);
		// title
		$title = $title_array[1];
		if($title == '') {
			$title = $title_array[2];
			if($title == '') {
				$title = $title_array[3];
			}
		}
		// エンティティ
		$title = htmlspecialchars_decode($title, ENT_QUOTES);
		// 置換（削除）
		$healthy = array('"', "'", '&#10;');
		$title = str_replace($healthy, '', $title);
		//////////
		//概要取得
		//////////
		$subject = str_replace('/', '', $subject);


//		$pattern = '/<meta(.+?)description(.+?)content="(.+?)">/i';  > を削除しただけ 2017.07.14 松岡
		$pattern = '/<meta(.+?)description(.+?)content="(.+?)"/i';
		// 概要検索
		preg_match($pattern, $subject, $description_array);

/*
  [3]=>
  string(1390) "でんぱ組.incは秋葉原ディアステージに所属しアニメ・漫画・ゲームなどの趣味に特化したコアなオタクでもある古川未鈴、相沢梨紗、夢眠ねむ、成瀬瑛美、最上もが、藤咲彩音の6人によるジャパニーズポップカルチャー最先端アイドルユニット。最上もがについて。" /><style>figure{margin:0}.tmblr-iframe{position:absolute}.tmblr-i
*/

		// description
		$description = $description_array[3];
		// 後ろに /がある場合
		if($description == NULL) {
			$pattern = '/<meta(.+?)description(.+?)content="(.+?)"(.+?)>/i';
			// 概要検索
			preg_match($pattern, $subject, $description_array);
			// description
			$description = $description_array[3];
			// null削除
			if($description == null){$description = '';}
		}
		// Twitterだったら
		if(preg_match('/twitter.com/', $url)) {
			$description = str_replace('最新ツイート', 'Twtterアカウント。', $description);
		}
//小笠原茉由(@chunma04)さん | Twitter
//小笠原茉由 (@chunma04)さんの最新ツイート。



		// エンティティ
		$$description = htmlspecialchars_decode($description, ENT_QUOTES);
		// 置換（削除）
		$healthy = array('"', "'", '&#10;');
		$$description = str_replace($healthy, '', $$description);
		////////////////
		//サムネイル取得
		////////////////
		$pattern = '/<meta(.+?)og:image(.+?)content="(.+?)">/i';
		// サムネイル検索
		preg_match($pattern, $subject, $shumbnail_array);
		// shumbnail
		$shumbnail = $shumbnail_array[3];
		// 後ろに /がある場合
		if($shumbnail == NULL) {
			$pattern = '/<meta(.+?)og:image(.+?)content="(.+?)"(.+?)>/i';
			// サムネイル検索
			preg_match($pattern, $subject, $shumbnail_array);
			// shumbnail
			$shumbnail = $shumbnail_array[3];
		}
		if($title) {
			$check = true;
		}
			else {
				$check = false;
			}
		header ("Content-Type: text/javascript; charset=utf-8");
		$json_data = array(
					'url'               => $url,
					'title'             => $title,
					'description'       => $description,
					'description_array' => $description_array,
					'shumbnail'         => $shumbnail,
					'shumbnail_array'   => $shumbnail_array,
					'check'             => $check, 
					'twitter_match'     => $twitter_match,
		);
		return json_encode($json_data);
	}
}
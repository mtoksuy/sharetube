<?php
/*
* Ajax まとめ URLのタイトル取得コントローラー
* 
* 
* 
*/
class Controller_Ajax_Matome_Urltitleget extends Controller {
	// アクション
	public function action_index() {
		// 変数
		$url = $_POST['url'];
		//リファラを設定
		$referer = 'http://sharetube.jp/';
		// 偽装オプション
		$options = array(
		  'http' => array(
		    'method' => 'GET',
		    'header' => 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:50.0) Gecko/20100101 Firefox/50.0',
//        'header'=>'User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:13.0) Gecko/20100101 Firefox/13.0.1\r\nReferer: '.$referer.'',
//				'header' => 'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
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

		$pattern = '/<title>(.+?)<\/title>|&lt;title&gt;(.+?)&lt;\/title&gt;/i';
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
		// 本文を60文字に丸める
		$title = mb_strimwidth($title, 0, 60, "...", 'utf8');

		if($title) {
			$check = true;
		}
			else {
				$check = false;
			}
		header ("Content-Type: text/javascript; charset=utf-8");
		$json_data = array(
					'url'   => $url,
					'title' => $title,
					'check' => $check, 
		);
		return json_encode($json_data);
	}
}
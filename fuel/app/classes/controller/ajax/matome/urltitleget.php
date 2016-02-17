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
		$context = stream_context_create(array('http'=>array('user_agent'=>'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0)')));
		$subject = $url_html = file_get_contents($url,false,$context);
		// UTF-8にエンコード
		$subject = mb_convert_encoding($subject, 'UTF-8', 'auto');
		$pattern = '/<title>(.+?)<\/title>|&lt;title&gt;(.+?)&lt;\/title&gt;/i';
		// title検索
		preg_match($pattern, $subject, $title_array);
		// title
		$title = $title_array[1];
		// エンティティ
		$title = htmlspecialchars_decode($title, ENT_QUOTES);
		// 置換（削除）
		$healthy = array('"', "'", '&#10;');
		$title = str_replace($healthy, '', $title);

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
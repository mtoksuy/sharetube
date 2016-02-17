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
		$subject = $url_html = file_get_contents($url);
		// UTF-8にエンコード
		$subject = mb_convert_encoding($subject, 'UTF-8', 'auto');


		//////////////
		//タイトル取得
		//////////////
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
		//////////
		//概要取得
		//////////
		$pattern = '/<meta(.+?)description(.+?)content="(.+?)">/i';
		// 概要検索
		preg_match($pattern, $subject, $description_array);
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
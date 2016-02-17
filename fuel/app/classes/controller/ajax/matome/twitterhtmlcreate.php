<?php
/*
* Ajax まとめ Twitter_HTML生成コントローラー
* 
* 
* 
*/
class Controller_Ajax_Matome_Twitterhtmlcreate extends Controller {
	// アクション
	public function action_index() {
		// セッションスタート
		session_start();
		// 変数
		$tweet_url = $_POST['tweet_url'];
		$subject = $tweet_url;
//		$subject = 'https://twitter.com/mtoksuy/status/583193602890735616';
		header ("Content-Type: text/javascript; charset=utf-8");

		// 改行コード\nへ変換
		$subject = str_replace("\r\n", "\n", $subject);
		$subject = str_replace("\r", "\n", $subject);
		$subject = str_replace(" ", "\n", $subject);
		$subject = str_replace("　", "\n", $subject);
		$subject = str_replace(",", "\n", $subject);
		$subject = str_replace("、", "\n", $subject);
		// 末に改行を追加
		$subject .= "\n";

		$pattern = '/https:\/\/(.+?)status\/(.+?)\n/';
		preg_match_all($pattern, $subject, $tweet_url_array);
		// 改行削除
		$tweet_url_array[0] = str_replace("\n", "", $tweet_url_array[0]);		

		// ツイートの数
		$tweet_number = 0;

		// tweetスクレイピング&HTML生成
		foreach($tweet_url_array[0] as $key => $value) {
			$tweet_data_array  = Model_Login_Twitterscraping_Basis::Twitter_scraping($value);
			$tweet_html       .= Model_Login_Twitterscraping_Html::tweet_html_create($tweet_data_array);
			$tweet_number++;
		}
		// チェック判定変数
		$check = TRUE;
		if(preg_match('/<span>@<\/span>/', $tweet_html, $match_array)) {
			$check = NULL;
		}
		if($tweet_html == NULL) {
			$check = NULL;
		}
		$json_data = array(
					'tweet_html'   => $tweet_html,
					'check'        => $check,
					'tweet_url'    => $tweet_url,
					'tweet_number' => $tweet_number,
		);
		return json_encode($json_data);
	}
}
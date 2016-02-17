<?php
/*
* バグコントローラー
* 
* 
* 
* 
*/

class Controller_Bug extends Controller {
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	//----------
	//アクション
	//----------
	public function action_index() {

		$res = DB::query("
			SELECT *
				FROM article
				WHERE del = 0
")->execute();
//		var_dump($res);

		$twitter_url = 'https://twitter.com';
		$pattern_1 = '/href="\/(.+?)" class="twitter-atreply pretty-link js-nav"/';
//		$pattern_1 = '/class="twitter-atreply pretty-link js-nav" href="\/(.+?)"/';
		$pattern_2 = '/href="(.+?)"/';

		foreach($res as $key => $value) {
			preg_match_all($pattern_1, $value["sub_text"], $replay_link_create_array);
			echo '<pre>';
//			var_dump($replay_link_create_array);
			echo '</pre>';
			foreach($replay_link_create_array[0] as $key_2 => $value_2) {
				preg_match($pattern_2, $value_2, $href_array);
				if($value_2) {
					echo '<pre>';
					var_dump($value_2);
					echo '</pre>';
					$value["sub_text"] = str_replace($value_2, 	'href="'.$twitter_url.$href_array[1].'" class="twitter-atreply pretty-link js-nav"', $value["sub_text"]);
				}
			}
/*
			DB::query("
				UPDATE
					article
					SET sub_text = '".$value["sub_text"]."'
					WHERE primary_id = ".$value["primary_id"]."")->execute();
*/
		}
	}
	//------------
	//エラーページ
	//------------
	public function action_404() {

	}
}
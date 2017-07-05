<?php
/*
* テストコントローラー
* 
* 
* 
* 
*/

class Controller_Test extends Controller_Test_Template {
	// ルーター
	public function router($method, $params) {
//		var_dump($method, $params);
		if($method == 'index') {
			$this->action_index();
		}
			else {
				$this->action_404();
			}
	}
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	//----------
	//アクション
	//----------
	public function action_index() {
/*
		for($i = 0; $i < 2; $i++) {
			$theme_res = Model_Theme_Basis::theme_res_get($i, 3600);
			$theme_curator_data_array = Model_Theme_Basis::theme_curator_data_array_get($theme_res);
		}
*/

		// テーマの名前取得
		$theme_name = Model_Theme_Basis::theme_name_get(1, 3600);
		// テーマres取得
		$theme_res = Model_Theme_Basis::theme_res_get(1, 3600);
		// テーマのキュレーターデータarray取得
		$theme_curator_data_array = Model_Theme_Basis::theme_curator_data_array_get($theme_res);
		/*
				// 謎の変換からarray形式に戻す(超大事)
				$arr = unserialize($inData);
		
		*/
		// 配列を謎の形式に変換
		$all_data           = serialize($theme_curator_data_array);
		$all_data = unserialize($all_data);




	}
}

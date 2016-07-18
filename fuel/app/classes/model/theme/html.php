<?php
/*
* 
* テーマ関連のHtmlクラス
* 
* 
* 
*/

class Model_Theme_Html extends Model {
	//--------------------
	//テーマデータHTML生成
	//--------------------
	public static function theme_data_html_create($theme_res) {
		foreach($theme_res as $key => $value) {
//			pre_var_dump($value);
/*
array(6) {
  ["primary_id"]=>
  string(4) "7050"
  ["theme_name"]=>
  string(9) "カモメ"
  ["theme_link_name"]=>
  string(3) "s0D"
  ["theme_summary"]=>
  string(0) ""
  ["del"]=>
  string(1) "0"
  ["create_time"]=>
  string(19) "2016-07-17 01:10:59"
}
*/
			$theme_data_html = '
				<div class="theme_data_card">
					<div class="theme_data_card_inner">
						<div class="theme_auxiliary">
							テーマ
						</div>
						<div class="theme_title">
							'.$value['theme_name'].'
						</div>
						<div class="theme_summary">
							'.$value['theme_summary'].'
						</div>
						<div class="theme_follow">
							<span class="typcn typcn-plus"></span>
							フォロー
						</div>
					</div>
				</div>';
		}
		return $theme_data_html;                 
	}
	//------------------
	//テーマ一覧HTML生成
	//------------------
	public static function theme_list_html_create($theme_res) {
		foreach($theme_res as $key => $value) {
			// テーマ一覧res取得
			$theme_list_res = Model_Theme_Basis::theme_list_res_get($value['theme_name']);
			// 記事一覧HTML生成
			$theme_list_html = Model_Article_Html::itype_list_html_create($theme_list_res);
		}
		return $theme_list_html;
	}
	//------------------------
	//テーマのまとめ数HTML生成
	//------------------------
	public static function theme_count_html_create($theme_res) {
		foreach($theme_res as $key => $value) {
			// テーマまとめ数res取得
			$theme_count_res = Model_Theme_Basis::theme_count_res_get($value['theme_name']);
			foreach($theme_count_res as $theme_count_key => $theme_count_value) {
				$theme_count_num = $theme_count_value['COUNT(*)'];
			}
			$theme_count_html = '
<div class="theme_count">
	<h2>テーマ 「'.$value['theme_name'].'」のまとめ<span class="theme_count_number">'.$theme_count_num.'</span>件</h2>
</div>';

// ここまでやった BBQ まえ


		}
		return $theme_count_html;
	}
}

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
			$theme_data_html = '
				<div class="theme_data_card">
					<div class="theme_data_card_inner">
						<div class="theme_auxiliary">
							テーマ
						</div>
						<h1 class="theme_title">
							<a href="'.HTTP.'theme/'.$value['primary_id'].'/">'.$value['theme_name'].'</a>
						</h1>
						<div class="theme_summary">
							'.$value['theme_summary'].'
						</div>
						<div class="theme_follow">
							<span class="typcn typcn-plus"></span>
							フォロー
						</div>
						<div class="theme_follow_text">
フォロー機能は近日中に実装予定です。
						</div>
					</div>
				</div>';
		}
		return $theme_data_html;                 
	}
	//------------------
	//テーマ一覧HTML生成
	//------------------
	public static function theme_list_html_create($theme_res, $paging_method) {
		foreach($theme_res as $key => $value) {
			// テーマ一覧res取得
			$theme_list_res = Model_Theme_Basis::theme_list_res_get($value['theme_name'], '10', $paging_method);
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
	テーマ 「<h2>'.$value['theme_name'].'</h2>」のまとめ<span class="theme_count_number">'.$theme_count_num.'</span>件
</div>';
		}
		return $theme_count_html;
	}
	//------------------------
	//テーマページングHTML生成
	//------------------------
	public static function theme_paging_html_create($theme_res, $theme_paging_data_array) {
		foreach($theme_res as $key => $value) {
			$theme_primary_id = $value['primary_id'];
		}
/*
	array(4) { ["last_num"]=> int(922) ["list_num"]=> int(10) ["paging_num"]=> int(1) ["max_paging_num"]=> int(93) } 
*/

// prev作成
if($theme_paging_data_array['max_paging_num'] >= 2 && $theme_paging_data_array['paging_num'] >= 2) {
	$prev_num = $theme_paging_data_array['paging_num']-1;
	$paging_prev_li = '<li class="sp_left"><a href="'.HTTP.'theme/'.$theme_primary_id.'/'.$prev_num.'/">Prev</a></li>';
}
// next作成
if($theme_paging_data_array['paging_num'] < $theme_paging_data_array['max_paging_num']) {
	$next_num = $theme_paging_data_array['paging_num']+1;
	$paging_next_li = '<li class="sp_right"><a href="'.HTTP.'theme/'.$theme_primary_id.'/'.$next_num.'/">Next</a></li>';
}
// チェック
if(($theme_paging_data_array['paging_num'] - 5) > 0) { $left_check = true; } else {$left_check = false; }
// チェック
if(($theme_paging_data_array['paging_num'] + 5) <= $theme_paging_data_array['max_paging_num']) { $right_check = true; } else {$right_check = false; }
$left_brink_num = $theme_paging_data_array['paging_num'] - 1;
//$left_brink_num = 3 - 1;
$right_brink_num = $theme_paging_data_array['max_paging_num'] - $theme_paging_data_array['paging_num'];
//$right_brink_num = $theme_paging_data_array['max_paging_num'] - 90;

$starting_point = 0;
$end_point  = 0;
/////////////
// 起点と終点
/////////////
if($left_check) {
	$starting_point = $theme_paging_data_array['paging_num'] - 5;
}
	else {
		$starting_point = $theme_paging_data_array['paging_num'] - $left_brink_num;
	}
if($right_check) {
	$end_point = ($starting_point + 9);
	if($theme_paging_data_array['max_paging_num'] < $end_point) {
		$end_point = $theme_paging_data_array['max_paging_num'];
	}
}
	else {
		$end_point = $theme_paging_data_array['paging_num'] + $right_brink_num;
	}
/*
pre_var_dump($left_brink_num);
pre_var_dump($right_brink_num);
$max_id = $theme_paging_data_array['paging_num']+$right_brink_num;
pre_var_dump($max_id);
pre_var_dump($left_check);
pre_var_dump($right_check);
pre_var_dump($starting_point);
pre_var_dump($end_point);
*/
/*
var_dump($left_check);
var_dump($right_check);
var_dump($left_brink_num);
var_dump($right_brink_num);

echo('<br><br>');

var_dump($starting_point);
var_dump($end_point);
*/

		for($starting_point = $starting_point; $starting_point <= $end_point; $starting_point++) {
			if($starting_point == $theme_paging_data_array['paging_num']) {
				$paging_li_html .= '<li class="sp_hidden"><span>'.$starting_point.'</span></li>';
			}
				else {
					$paging_li_html .= '<li class="sp_hidden"><a href="'.HTTP.'theme/'.$theme_primary_id.'/'.$starting_point.'/">'.$starting_point.'</a></li>';
				}
		}
	$paging_html = 
		'<div class="recommend_article_paging">
			<div class="recommend_article_paging_inner">
				<ul class="clearfix">
					'.$paging_prev_li.'
					'.$paging_li_html.'
					'.$paging_next_li.'
				</ul>
			</div>
		</div>';
		return $paging_html;
	}
}

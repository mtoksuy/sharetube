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
	public static function theme_list_html_create($theme_res, $paging_method, $cached = 900) {
		foreach($theme_res as $key => $value) {
			// テーマ一覧res取得
			list($theme_list_res, $theme_article_data_array) = Model_Theme_Basis::theme_list_res_get($value['theme_name'], '10', $paging_method, $cached);
			// 記事一覧HTML生成
			$theme_list_html = Model_Article_Html::itype_list_html_create($theme_list_res);
		}
		return array($theme_list_html, $theme_article_data_array);
	}
	//------------------------
	//テーマのまとめ数HTML生成
	//------------------------
	public static function theme_count_html_create($theme_paging_data_array, $theme_article_data_array) {
			$theme_count_html = '
				<div class="theme_count">
					テーマ 「<h2>'.$theme_article_data_array['theme_name'].'</h2>」のまとめ<span class="theme_count_number">'.$theme_paging_data_array['last_num'].'</span>件
				</div>';
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
	//------------------
	//関連テーマHTML生成
	//------------------
	public static function theme_relation_html_create($theme_res, $theme_relation_2_array, $cached = 900) {
		foreach($theme_res as $key => $value) {
			$theme_name = $value['theme_name'];
		}
		$i = 0;
		foreach($theme_relation_2_array as $key_2 => $value_2) {
//pre_var_dump($value_2['count']);
			if($value_2['theme_name'] != $theme_name && $i < 25) {
				$i++;
					// テーマres取得
					$theme_res = Model_Theme_Basis::tag_name_in_theme_res_get($value_2['theme_name'], $cached);
					foreach($theme_res as $theme_key => $theme_value) {
						// テーマ一覧HTML生成
						list($theme_list_html, $theme_article_data_array) = Model_Theme_Html::theme_list_html_create($theme_res, 1, 0);
						// テーマカウント数res取得
						$theme_count_res = Model_Theme_Basis::theme_count_res_get($theme_value['theme_name'], $cached);
						foreach($theme_count_res as $theme_count_key => $theme_count_value) {
							$theme_li .= 
								'<li><a href="'.HTTP.'theme/'.$theme_value['primary_id'].'/"><span class="typcn typcn-folder"></span>'.$theme_value['theme_name'].'('.$theme_article_data_array['list_num'].')</a></li>';
						}
					}
			}
		}
		// 関連テーマHTML生成
		$theme_relation_html = ('
			<div class="theme_relation">
				<h2>関連テーマ</h2>
				<ul class="clearfix">
						'.$theme_li.
				'</ul>
			</div>');
		return $theme_relation_html;
	}
}

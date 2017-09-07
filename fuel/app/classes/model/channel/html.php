<?php
/*
* 
* チャンネル 記事HTML関連クラス
* 
* 
* 
*/

class Model_Channel_Html extends Model {
	//--------------------------
	//プロフィールカードHTML生成
	//--------------------------
	public static function profile_card_html_create($sharetube_user_data_array, $article_count) {
//		echo '<pre>';
//		var_dump($sharetube_user_data_array,$article_count);
//		echo '</pre>';
		$management_site_url_html = '';
		if($sharetube_user_data_array["management_site_url"]) {
			$management_site_url_html = 
				'<div class="profile_card_content_site">
					<a target="_blank" href="'.$sharetube_user_data_array["management_site_url"].'"><span class="typcn typcn-home-outline"></span>運営サイト</a>
				</div>';
		}
		// snsのリンクhtml生成
		$account_list_html = Model_Article_Html::sns_account_list_html_crete($sharetube_user_data_array);
		// プロフィールカードHTML生成
		$profile_card_html = 
			'<div class="profile_card">
				<div class="profile_card_content">
					<div class="profile_card_content_data clearfix">
						<div class="profile_card_content_data_left">
							<a class="o_8" href="'.HTTP.'channel/'.$sharetube_user_data_array["sharetube_id"].'/">
								<img width="128" height="128" title="'.$sharetube_user_data_array["name"].'" alt="'.$sharetube_user_data_array["name"].'" src="'.HTTP.'assets/img/creators/icon/'.$sharetube_user_data_array["profile_icon"].'">
							</a>
						</div> <!-- profile_card_content_data_left -->
						<ul class="profile_card_content_data_right">
							<li class="profile_card_content_data_right_top">
								<span class="profile_card_content_data_right_top_summary">'.$article_count.'</span>
								<span class="profile_card_content_data_right_top_matome_create_number">まとめ作成数</span>
							</li>
							<li class="profile_card_content_data_right_bottom">
								<span class="profile_card_content_data_right_bottom_summary">'.$sharetube_user_data_array["all_page_view"].'</span>
								<span class="profile_card_content_data_right_bottom_all_page_view">総ページビュー</span>
							</li>
						</ul>  <!-- profile_card_content_data_right -->
					</div> <!-- profile_card_content_data -->
					<div class="profile_card_content_name">
						<h5><a href="'.HTTP.'channel/'.$sharetube_user_data_array["sharetube_id"].'/">'.$sharetube_user_data_array["name"].'</a></h5>
					</div>
					<div class="profile_card_content_summary">
						<p class="m_0">'.$sharetube_user_data_array["profile_contents"].'</p>
					</div>
						'.$management_site_url_html.'
						'.$account_list_html.'
				</div>
			</div>';
		return $profile_card_html;
	}
	//------------------
	//ページングHTML生成
	//------------------
	public static function paging_html_create($sharetube_id, $page) {
//		var_dump($sharetube_id, $page);
		switch($page) {
			case 0:
				$page++;
			break;
		}
			// Sharetubeユーザーの書いた記事数を取得
			$article_count = Model_Info_Basis::sharetube_user_article_count_get($sharetube_id);
			$page_number = ($article_count/10);
			// 端数切り上げ
//			$page_number = floor($page_number); // こっちは切り捨て
			$page_number = (int)ceil($page_number);

			for($i = 1;$i <= $page_number; $i++) {
				if($page == $i) {
					$li_html .= '<li><span>'.$i.'</span></li>';
				}
					else {
						$li_html .= '<li><a href="'.HTTP.'channel/'.$sharetube_id.'/'.$i.'/">'.$i.'</a></li>';
					}
			} // for($i = 1;$i <= $page_number; $i++) {
			// 合体
			$paging_html = 
				'<div class="paging">
					<ul class="clearfix">
						'.$li_html.'
					</ul>
				</div>';
			return $paging_html;
	}
	//--------------------
	//チャンネルのmeta生成
	//--------------------
	public static function channel_meta_create($meta_data) {
		if($meta_data) {
			$meta_html = '<meta name="description" content="'.$meta_data.'" />';		
		}
			else {
				$meta_html = '';		
			}
		return $meta_html;
	}
	//--------------------------
	//チャンネルヘッダーHTML生成
	//--------------------------
	public static function channel_header_html_create($method, $function_name) {
		switch($function_name) {
			case 'recommendarticle':
				$recommendarticle_css_class = 'now ';
				$href_html = '<a href="'.HTTP.'channel/'.$method.'/">作成まとめ</a>';
				$recommendarticle_href_html = '注目';
				$famearticle_href_html = '<a href="'.HTTP.'channel/'.$method.'/famearticle/">殿堂</a>';
				$like_href_html = '<a href="'.HTTP.'channel/'.$method.'/like/">いいね</a>';
			break;
			case 'famearticle':
				$famearticle_css_class = 'now ';
				$href_html = '<a href="'.HTTP.'channel/'.$method.'/">作成まとめ</a>';
				$recommendarticle_href_html = '<a href="'.HTTP.'channel/'.$method.'/recommendarticle/">注目</a>';
				$famearticle_href_html = '殿堂';
				$like_href_html = '<a href="'.HTTP.'channel/'.$method.'/like/">いいね</a>';
			break;
			case 'like':
				$like_css_class = 'now ';
				$href_html = '<a href="'.HTTP.'channel/'.$method.'/">作成まとめ</a>';
				$recommendarticle_href_html = '<a href="'.HTTP.'channel/'.$method.'/recommendarticle/">注目</a>';
				$famearticle_href_html = '<a href="'.HTTP.'channel/'.$method.'/famearticle/">殿堂</a>';
				$like_href_html = 'いいね';
			break;
			default:
				$css_class = 'now ';
				$href_html = '作成まとめ';
				$recommendarticle_href_html = '<a href="'.HTTP.'channel/'.$method.'/recommendarticle/">注目</a>';
				$famearticle_href_html = '<a href="'.HTTP.'channel/'.$method.'/famearticle/">殿堂</a>';
				$like_href_html = '<a href="'.HTTP.'channel/'.$method.'/like/">いいね</a>';
			break;
		}
		$channel_header_html = 
			'<div class="card_article_header">
				<ul class="type_list clearfix">
					<li class="'.$css_class.'clearfix">'.$href_html.'</li>
					<li class="'.$recommendarticle_css_class.'clearfix">'.$recommendarticle_href_html.'</li>
					<li class="'.$famearticle_css_class.'clearfix">'.$famearticle_href_html.'</li>
					<li class="'.$like_css_class.'clearfix">'.$like_href_html.'</li>
				</ul>
			</div>';
//http://localhost/sharetube/channel/mosimo/like/34/
		return $channel_header_html;
	}
	//------------------------------------
	//チャンネルまとめのページングHTML生成
	//------------------------------------
	public static function channel_article_paging_html_create($channel_article_paging_data_array, $sharetube_id, $directory_name = 'channel') {
//		var_dump($channel_article_paging_data_array);
/*
	array(4) { ["last_num"]=> int(922) ["list_num"]=> int(10) ["paging_num"]=> int(1) ["max_paging_num"]=> int(93) } 
*/

//var_dump($channel_article_paging_data_array);
// prev作成
if($channel_article_paging_data_array['max_paging_num'] >= 2 && $channel_article_paging_data_array['paging_num'] >= 2) {
	$prev_num = $channel_article_paging_data_array['paging_num']-1;
	$paging_prev_li = '<li class="sp_left"><a href="'.HTTP.$directory_name.'/'.$sharetube_id.'/'.$prev_num.'/">Prev</a></li>';
}
// next作成
if($channel_article_paging_data_array['paging_num'] < $channel_article_paging_data_array['max_paging_num']) {
	$next_num = $channel_article_paging_data_array['paging_num']+1;
	$paging_next_li = '<li class="sp_right"><a href="'.HTTP.$directory_name.'/'.$sharetube_id.'/'.$next_num.'/">Next</a></li>';
}
// チェック
if(($channel_article_paging_data_array['paging_num'] - 5) > 0) { $left_check = true; } else {$left_check = false; }
// チェック
if(($channel_article_paging_data_array['paging_num'] + 5) <= $channel_article_paging_data_array['max_paging_num']) { $right_check = true; } else {$right_check = false; }
/*
<div class="recommend_article_paging">
	<div class="recommend_article_paging_inner">
		<ul class="clearfix">
			<li><a href="http://programmerbox.com/1/">Prev</a></li>
			<li><a href="http://programmerbox.com/1/">1</a></li>
			<li><span>2</span></li>
			<li><a href="http://programmerbox.com/3/">3</a></li>
			<li><a href="http://programmerbox.com/4/">4</a></li>
			<li><a href="http://programmerbox.com/5/">5</a></li>
			<li><a href="http://programmerbox.com/3/">6</a></li>
			<li><a href="http://programmerbox.com/4/">7</a></li>
			<li><a href="http://programmerbox.com/5/">8</a></li>
			<li><a href="http://programmerbox.com/5/">9</a></li>
			<li><a href="http://programmerbox.com/5/">10</a></li>

			<li><a href="http://programmerbox.com/3/">Next</a></li>
		</ul>
	</div>
</div>
*/


/*
	array(4) { ["last_num"]=> int(922) ["list_num"]=> int(10) ["paging_num"]=> int(1) ["max_paging_num"]=> int(93) } 
*/
// 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15


$left_brink_num = $channel_article_paging_data_array['paging_num'] - 1;
//$left_brink_num = 3 - 1;
$right_brink_num = $channel_article_paging_data_array['max_paging_num'] - $channel_article_paging_data_array['paging_num'];
//$right_brink_num = $channel_article_paging_data_array['max_paging_num'] - 90;

$starting_point = 0;
$end_point  = 0;
/////////////
// 起点と終点
/////////////
if($left_check) {
	$starting_point = $channel_article_paging_data_array['paging_num'] - 5;
}
	else {
		$starting_point = $channel_article_paging_data_array['paging_num'] - $left_brink_num;
	}
if($right_check) {
	$end_point = ($starting_point + 9);
	if($channel_article_paging_data_array['max_paging_num'] < $end_point) {
		$end_point = $channel_article_paging_data_array['max_paging_num'];
	}
}
	else {
		$end_point = $channel_article_paging_data_array['paging_num'] + $right_brink_num;
	}
/*
pre_var_dump($left_brink_num);
pre_var_dump($right_brink_num);
$max_id = $channel_article_paging_data_array['paging_num']+$right_brink_num;
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
			if($starting_point == $channel_article_paging_data_array['paging_num']) {
				$paging_li_html .= '<li class="sp_hidden"><span>'.$starting_point.'</span></li>';
			}
				else {
					$paging_li_html .= '<li class="sp_hidden"><a href="'.HTTP.$directory_name.'/'.$sharetube_id.'/'.$starting_point.'/">'.$starting_point.'</a></li>';
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

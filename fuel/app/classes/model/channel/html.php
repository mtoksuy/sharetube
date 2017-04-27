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
	//------------------------------
	//参加しているテーマ一覧HTML生成
	//------------------------------
	public static function user_join_theme_html_create($theme_res, $theme_relation_2_array, $cached = 900) {
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
						list($theme_list_html, $theme_article_data_array) = Model_Theme_Html::theme_list_html_create($theme_res, 1, $cached);
						// テーマカウント数res取得
						$theme_count_res = Model_Theme_Basis::theme_count_res_get($theme_value['theme_name'], $cached);
						foreach($theme_count_res as $theme_count_key => $theme_count_value) {
							$theme_li .= 
								'<li><a href="'.HTTP.'theme/'.$theme_value['primary_id'].'/"><span class="typcn typcn-tag"></span>'.$theme_value['theme_name'].'<span class="theme_num">'.$theme_article_data_array['list_num'].'</span></a></li>';
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












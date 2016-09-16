<?php 
class Model_Login_Itunesappscraping_Html extends Model {
	//-------------------
	//iTunes_app_html生成
	//-------------------
	public static function itunes_app_html_create($itunes_app_data_array, $description_check) {
//		var_dump($itunes_app_data_array);
/*
		$itunes_app_data_array = array();
		$itunes_app_data_array['title']        = $title_html;
		$itunes_app_data_array['developer']    = $developer_html;
		$itunes_app_data_array['description']  = $description_html;
		$itunes_app_data_array['price']        = $price_html;
		$itunes_app_data_array['category']     = $category_html;
		$itunes_app_data_array['release_date'] = $release_date_html;
		$itunes_app_data_array['version']      = $version_html;
		$itunes_app_data_array['size']         = $size_html;
		$itunes_app_data_array['system_cover'] = $system_cover_html;
		$itunes_app_data_array['rating']       = $rating_html;
		$itunes_app_data_array['rating_count'] = $rating_count_html;
		$itunes_app_data_array['icon']         = $icon_html;
		$itunes_app_data_array['screen_shots'] = $iphone_screen_shots_array[1];
*/


//////////////
//概要HTML生成
//////////////
if($description_check == 1) {
	$description_html = '
	<p class="matome_content_block_itunes_app_data_screenshots_title">説明</p>
			<div class="matome_content_block_itunes_app_data_description">
				<pre>'.$itunes_app_data_array['description'].'</pre>
			</div>
	';
}
	else {
	$description_html = '';
	}
//////////////////////
//screen_shotsHTML生成
//////////////////////
foreach($itunes_app_data_array['screen_shots_run'] as $key => $value) {
	$screen_shots_html .= 
		'<div class="gallery-cell">
			<a href="'.HTTP.'assets/img/itunes/app/'.$value.'" target="_blank">
				<img width="640" height="360" src="'.HTTP.'assets/img/itunes/app/'.$value.'">
			</a>
		</div>
';
}
////////////////
//ratingHTML生成
////////////////
//$itunes_app_data_array['rating'] = (int)floor($itunes_app_data_array['rating']);
$itunes_app_data_array['rating'] = (int)floor($itunes_app_data_array['rating']*2);
$rating_i = 10;
while($rating_i > 0) {
	if($itunes_app_data_array['rating'] >= 2) {
		$rating_i--;
		$rating_i--;
		$itunes_app_data_array['rating']--;
		$itunes_app_data_array['rating']--;
		$rating_html .= '<span class="typcn typcn-star"></span>
';
	}
		else if($itunes_app_data_array['rating'] == 1) {
			$rating_i--;
			$rating_i--;
			$itunes_app_data_array['rating']--;
			$rating_html .= '<span class="typcn typcn-star-half-outline"></span>
';
		}
			else {
				$rating_i--;
				$rating_i--;
				$itunes_app_data_array['rating']--;
				$itunes_app_data_array['rating']--;
				$rating_html .= '<span class="typcn typcn-star-outline"></span>
';
		}
}



		$itunes_app_html = 
'<div class="matome_content_block_itunes_app">
		<div class="matome_content_block_itunes_app_title">
			<h3>'.$itunes_app_data_array['title'].'</h3>
		</div>
		<div class="clearfix">
			<div class="matome_content_block_itunes_app_icon">
				<a href="'.$itunes_app_data_array['itunes_app_url'].'" class="o_8" target="_blank">
				<img width="200" src="'.HTTP.'assets/img/itunes/app/'.$itunes_app_data_array['icon_run'][0].'">
				</a>
			</div>
			<div class="matome_content_block_itunes_app_data clearfix">
				<div class="matome_content_block_itunes_app_data_more">
					<a href="'.$itunes_app_data_array['itunes_app_url'].'" target="_blank">詳しく見る</a>
				</div>
				<div class="matome_content_block_itunes_app_data_badge">
					<a href="'.$itunes_app_data_array['itunes_app_url'].'" class="o_8" target="_blank">
						<img width="135" height="40" src="'.HTTP.'assets/img/common/badge_appstore-lrg.png">
					</a>
				</div>
				<div class="matome_content_block_itunes_app_data_rating">
					'.$rating_html.'
					('.$itunes_app_data_array['rating_count'].')
				</div>
			</div> <!-- matome_content_block_itunes_app_data -->
		</div> <!-- clearfix -->
		<div class="matome_content_block_itunes_app_data_price">
			<b>'.$itunes_app_data_array['price'].'</b>
		</div>
		<div class="matome_content_block_itunes_app_data_developer">開発元：'.$itunes_app_data_array['developer'].'</div>	
		<div class="matome_content_block_itunes_app_data_category">カテゴリー：'.$itunes_app_data_array['category'].'</div>
		<div class="matome_content_block_itunes_app_data_release_date">リリース日：'.$itunes_app_data_array['release_date'].'</div>
		<div class="matome_content_block_itunes_app_data_varsion">バージョン：'.$itunes_app_data_array['version'].'</div>
		<div class="matome_content_block_itunes_app_data_size">容量：'.$itunes_app_data_array['size'].'</div>
		<div class="matome_content_block_itunes_app_data_system_cover">互換性：'.$itunes_app_data_array['system_cover'].'</div>

			'.$description_html.'

		<p class="matome_content_block_itunes_app_data_screenshots_title">スクリーンショット</p>
		<div class="matome_content_block_itunes_app_data_screenshots">
			'.$screen_shots_html.'
		</div>
	</div> <!-- matome_content_block_itunes_app -->';
		return $itunes_app_html;
	}
}

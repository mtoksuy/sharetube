<?php 
class Model_Login_Amazonscraping_Html extends Model {
	//----------------
	//アマゾンHTML生成
	//----------------
	public static function amazon_html_create($amazon_data_array) {
		////////////////
		//ratingHTML生成
		////////////////
		if($amazon_data_array['rating']) {
			$rating_i = 5;
			while($rating_i > 0) {
				$rating_i--;
				$amazon_data_array['rating']--;
				if($amazon_data_array['rating'] >= 0) {
					$rating_html .= '<span class="typcn typcn-star"></span>
			';
				}
					else {
						$rating_html .= '<span class="typcn typcn-star-outline"></span>
			';
					}
			} // while($rating_i > 0) {
			// 完成
			$rating_html = 
				'<div class="amazon_link_data_rating">
					'.$rating_html.'
				</div>';
		} // if($amazon_data_array['rating']) {
			else {
				$rating_html = '';
			}
		////////////////////////////
		//カスタマーレビューHTML生成
		////////////////////////////
		if($amazon_data_array['review']) {
			$review_html = 
				'<div class="amazon_link_data_review">
					'.$amazon_data_array['review'].'
				</div>';
		} // if($amazon_data_array['review']) {
			else {
				$review_html = '';
			}
		//////////////////
		//参考価格HTML生成
		//////////////////
		if($amazon_data_array['price_strike']) {
			$price_strike_html = 
				'<div class="amazon_link_data_block">
					<span class="price_title">参考価格：</span>
					<span class="amazon_link_data_price_strike">
						'.$amazon_data_array['price_strike'].'
					</span>
				</div>';
		} // if($amazon_data_array['price_strike']) {
			else {
				$price_strike_html = '';
			}
		//////////////
		//価格HTML生成
		//////////////
		if($amazon_data_array['price']) {
			$price_html = 
				'<div class="amazon_link_data_block">
					<span class="price_title">価格：</span>
					<span class="amazon_link_data_price">
						'.$amazon_data_array['price'].'
					</span>
				</div>';
		} // if($amazon_data_array['price']) {
			else {
				$price_html = '';
			}
		/////////////////
		//OFF価格HTML生成
		/////////////////
		if($amazon_data_array['price_off']) {
			$price_off_html = 
				'<div class="amazon_link_data_block">
					<span class="price_title">OFF：</span>
					<span class="amazon_link_data_price_off">
						'.$amazon_data_array['price_off'].'
					</span>
				</div>';
		} // if($amazon_data_array['price_off']) {
			else {
				$price_off_html = '';
			}
		//////////////////
		//中古価格HTML生成
		//////////////////
		if($amazon_data_array['price_offer']) {
			$price_offer_html = 
				'<div class="amazon_link_data_block">
					<span class="price_title">中古品：</span>
					<span class="amazon_link_data_price_offer">
						'.$amazon_data_array['price_offer'].'
					</span>
				</div>';
		} // if($amazon_data_array['price_offer']) {
			else {
				$price_offer_html = '';
			}
		//////////////////
		//アマゾンHTML生成
		//////////////////
		$amazon_html = 
				'<div class="amazon_link_data">
					'.$rating_html.
						$review_html.
						$price_strike_html.
						$price_html.
						$price_off_html.
						$price_offer_html.
				'</div>';
		return $amazon_html;
	} // public static function amazon_html_create($amazon_data_array) {
}

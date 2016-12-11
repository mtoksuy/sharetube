<?php 

/**
 * アマゾンのスクレイピング関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Amazonscraping_Basis extends Model {
	////////////////////////
	//アマゾンスクレイピング
	////////////////////////
	public static function amazon_scraping($url) {
//		$url = "http://www.amazon.co.jp/%E3%82%B0%E3%83%83%E3%83%81-GUCCI-%E3%83%AA%E3%83%B3%E3%82%B0-225985-I19A1-%E6%97%A5%E6%9C%AC%E3%82%B5%E3%82%A4%E3%82%BA12%E5%8F%B7/dp/B008EJWT80/ref=sr_1_28?s=jewelry&ie=UTF8&qid=1452611983&sr=1-28";
		// simple_html_domライブラリ読み込み
		require_once INTERNAL_PATH.'fuel/app/classes/library/simplehtmldom_1_5/simple_html_dom.php';
/*
500エラー
フタックオーバーフローの
解決案
$string = file_get_contents(http://thedeadfallproject.com/)
$object = new simple_html_dom();
$object->load($string); // Load HTML from a string
*/
/*
改善前のコード
		// URLから
//		$simple_html_dom_object = file_get_html($url);

2016.01.22 松岡
*/
		$string = file_get_contents($url);
		$object = new simple_html_dom();
		$simple_html_dom_object = $object->load($string); // Load HTML from a string

		//////////
		//評価抽出
		//////////
		// コンテンツ取得
		foreach($simple_html_dom_object->find('#acrPopover') as $list) {
			 $noUnderline_html .= $list->outertext;
		}
		$pattern = '/title="(.+?)"/';
		preg_match_all($pattern, $noUnderline_html, $rating_preg_array);
		$rating_number = (int)str_replace('5つ星のうち ','',$rating_preg_array[1][0]);

		//////////////////////////
		//カスタマーレビュー数抽出
		//////////////////////////
		// コンテンツ取得
		foreach($simple_html_dom_object->find('#acrCustomerReviewText') as $list) {
			 $acrCustomerReviewText_html .= $list->outertext;
		}
		$pattern = '/<span (.+?)>(.+?)<\/span>/';
		preg_match_all($pattern, $acrCustomerReviewText_html, $review_preg_array);
		$review_text = $review_preg_array[2][0];
		////////////////
		//参考お値段抽出
		////////////////
		// コンテンツ取得
		foreach($simple_html_dom_object->find('.a-text-strike') as $list) {
			 $price_strike_html .= $list->outertext;
		}
		$pattern = '/<td (.+?)>(.+?)<\/td>/';
		preg_match_all($pattern, $price_strike_html, $price_strike_preg_array);
		$price_strike_text = $price_strike_preg_array[2][0];
		// ない場合
		if($price_strike_text  == null) {
			$pattern = '/<span (.+?)>(.+?)<\/span>/';
			preg_match_all($pattern, $price_strike_html, $price_strike_preg_array);
			$price_strike_text = $price_strike_preg_array[2][0];
		}
		////////////
		//お値段抽出
		////////////
		// コンテンツ取得
		foreach($simple_html_dom_object->find('#price_feature_div') as $list) {
			 $price_html .= $list->outertext;
		}
		$pattern = '/<span id="priceblock_ourprice"(.+?)>(.+?)<\/span>/';
		preg_match_all($pattern, $price_html, $price_preg_array);
		$price_text = $price_preg_array[2][0];
		// 本の場合
		if($price_text == null) {
			// コンテンツ取得
			foreach($simple_html_dom_object->find('.olp-new') as $list) {
				 $price_html .= $list->outertext;
			}
			$pattern = '/￥(.+?) <span/';
			preg_match_all($pattern, $price_html, $price_preg_array);
			$price_text = str_replace('<span','',$price_preg_array[0][0]);
		}
		//////////////////
		//プライスオフ抽出
		//////////////////
		$pattern = '/<td (.+?)>(.+?)<\/td>/';
		preg_match_all($pattern, $price_html, $price_preg_array);
		$price_off_text = $price_preg_array[2][5];
		 $price_off_text = str_replace('	', '',$price_off_text);

		//////////////////
		//中古のお値段抽出
		//////////////////
		// コンテンツ取得
		foreach($simple_html_dom_object->find('.offer-price') as $list) {
			 $offer_price_html .= $list->outertext;
		}
/*
<pre>string(140) "<span class="a-color-price offer-price a-text-normal">￥ 4,100</span><span class="a-color-price
 offer-price a-text-normal">￥ 2,300</span>"
間違い

*/
//pre_var_dump($offer_price_html);
/*
<span class="olp-padding-right"><a href="/gp/offer-listing/B00BXVR8FU/ref=dp_olp_used?ie=UTF8&amp;condition=used">中古品の出品：21</a><span class="a-color-price">￥ 45,500</span>より</span>

これから

<span class="olp-used olp-link">
  <a class="a-size-mini a-link-normal" href="/gp/offer-listing/4781700748/ref=tmm_pap_used_olp_sr?ie=UTF8&amp;condition=used&amp;qid=1481437450&amp;sr=8-13">    
     ￥ 322 <span class="olp-from">より</span> 10 中古品の出品 
  </a>        
</span>
*/
		$pattern = '/<span class="(.+?)">(.+?)<\/span>/';
		preg_match_all($pattern, $offer_price_html, $offer_price_preg_array);
		// 2016.12.11 中古表示がおかしい とりあえず非表示で 松岡
//		$offer_price_text = $offer_price_preg_array[2][1];
		///////////////////////
		//amazon_data_array生成
		///////////////////////
		$amazon_data_array = array();
		$amazon_data_array['rating']       = $rating_number;
		$amazon_data_array['review']       = $review_text;
		$amazon_data_array['price_strike'] = $price_strike_text;
		$amazon_data_array['price']        = $price_text;
		$amazon_data_array['price_off']    = $price_off_text;
		$amazon_data_array['price_offer']  = $offer_price_text;
//		var_dump($itunes_app_data_array);
/*
		var_dump($rating_number);
		var_dump($review_text);
		var_dump($price_strike_text);
		var_dump($price_text);
		var_dump($price_off_text);
		var_dump($offer_price_text);
*/
		return $amazon_data_array;
	}
}
<?php 
/**
 * testコントローラー
 * 
 * 様々なテストをする場所
 * 
 * 
 */

class Controller_Login_Admin_Test extends Controller_Login_Template {
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {

			$url = "http://www.amazon.co.jp/gp/product/B00871HYMQ/ref=as_li_ss_il";

$url = "http://www.amazon.co.jp/dp/B00Y3TMKKM/ref=bb1_for77000129?pf_rd_m=AN1VRQENFRJN5&pf_rd_s=desktop-hero-A&pf_rd_r=1AZK88170PS07MEARW49&pf_rd_t=36701&pf_rd_p=263162929&pf_rd_i=desktop";

$url = "http://www.amazon.co.jp/gp/product/B004U4EQ9I/ref=br_asw_pdt-5?pf_rd_m=AN1VRQENFRJN5&pf_rd_s=desktop-2&pf_rd_r=1SNBTGM1MAXMA4ZN1VY7&pf_rd_t=36701&pf_rd_p=280006529&pf_rd_i=desktop";
$url="http://www.amazon.co.jp/gp/product/B00H8KCN0A/ref=br_asw_pdt-3?pf_rd_m=AN1VRQENFRJN5&pf_rd_s=desktop-3&pf_rd_r=6W18PVFCTERVWQMQZ6E8&pf_rd_t=36701&pf_rd_p=268105129&pf_rd_i=desktop";
$url = "http://www.amazon.co.jp/gp/product/B002SQLDS2/ref=s9_cartx_gw_d99_g60_i2?pf_rd_m=AN1VRQENFRJN5&pf_rd_s=desktop-6&pf_rd_r=FFEYA2KKWQRX0R2NX2N8&pf_rd_t=36701&pf_rd_p=205640849&pf_rd_i=desktop";


$url = "http://www.amazon.co.jp/%E7%94%9F%E3%81%8D%E6%96%B9%E2%80%95%E4%BA%BA%E9%96%93%E3%81%A8%E3%81%97%E3%81%A6%E4%B8%80%E7%95%AA%E5%A4%A7%E5%88%87%E3%81%AA%E3%81%93%E3%81%A8-%E7%A8%B2%E7%9B%9B-%E5%92%8C%E5%A4%AB/dp/4763195433/ref=sr_1_1?s=books&ie=UTF8&qid=1452610176&sr=1-1&keywords=%E7%94%9F%E3%81%8D%E3%82%8B";

$url = "http://www.amazon.co.jp/%E7%B4%94%E6%84%9B-%E3%83%91%E3%83%A9%E3%83%95%E3%82%A3%E3%83%AA%E3%82%A2--%E6%95%99%E8%82%B2%E5%AE%9F%E7%BF%92%E7%94%9F-%E5%AE%AE%E8%88%98%E6%8B%93%E7%B4%80-CV-%E4%BD%90%E5%92%8C%E7%9C%9F%E4%B8%AD/dp/B016NS5F1Q/ref=sr_1_31?s=software&ie=UTF8&qid=1452611560&sr=1-31&keywords=%E7%94%9F";


$url = "http://www.amazon.co.jp/%E3%82%B0%E3%83%83%E3%83%81-GUCCI-%E3%83%AA%E3%83%B3%E3%82%B0-225985-I19A1-%E6%97%A5%E6%9C%AC%E3%82%B5%E3%82%A4%E3%82%BA12%E5%8F%B7/dp/B008EJWT80/ref=sr_1_28?s=jewelry&ie=UTF8&qid=1452611983&sr=1-28";

		// simple_html_domライブラリ読み込み
		require_once INTERNAL_PATH.'fuel/app/classes/library/simplehtmldom_1_5/simple_html_dom.php';
		// URLから
		$simple_html_dom_object = file_get_html($url);
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
		$pattern = '/<span class="(.+?)">(.+?)<\/span>/';
		preg_match_all($pattern, $offer_price_html, $offer_price_preg_array);
		$offer_price_text = $offer_price_preg_array[2][1];




var_dump($rating_number);
var_dump($review_text);
var_dump($price_strike_text);
var_dump($price_text);
var_dump($price_off_text);
var_dump($offer_price_text);



















			return $this->login_admin_template;
		}
			// ログインしていない場合
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	}
}
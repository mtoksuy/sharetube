<?php
/*
* 
* 広告関HTML連クラス
* 
* 
* 
*/

class Model_Ad_Html extends Model {
	//-----------------
	//Fluct広告配信関数
	//-----------------
	static function fluct_ad_html_create($detect, $pc_type =  "サイドバー右上", $mobile_type = "ミドル_1") {


//	var_dump($pc_type);
//	var_dump($mobile_type);

/*
トップページのタグだが統合して表示するのでいらない
		$fluct_sidebar_top_ad_html = '<!--      Fluct グループ名「Sharetube:300x250（サイドバー右上TOP）」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027848&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube:300x250（サイドバー右上TOP）」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043199'."'".');
//]]>
</script>';
		$fluct_sidebar_middle_ad_html = '<!--      Fluct グループ名「Sharetube:300x250（サイドバー右TOP）」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027847&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube:300x250（サイドバー右TOP）」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043200'."'".');
//]]>
</script>';
*/

		// PC版広告群
		$fluct_pc_sidebar_top_ad_html = '<!--      Fluct グループ名「Sharetube：300×250（サイドバー右上）」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027784&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube：300×250（サイドバー右上）」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043103'."'".');
//]]>
</script>';

		$fluct_pc_sidebar_under_ad_html = '<!--      Fluct グループ名「Sharetube：300×250（サイドバー右下）」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027785&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube：300×250（サイドバー右下）」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043104'."'".');
//]]>
</script>';

		$fluct_pc_article_middle_left_ad_html = '<!--      Fluct グループ名「Sharetube：300×250（ミドル左）」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027787&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube：300×250（ミドル左）」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043106'."'".');
//]]>
</script>';
		$fluct_pc_article_middle_right_ad_html = '<!--      Fluct グループ名「Sharetube：300×250（ミドル右）」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027786&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube：300×250（ミドル右）」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043105'."'".');
//]]>
</script>';

		$fluct_pc_article_under_ad_html = '<!--      Fluct グループ名「Sharetube：300×250（記事下）」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027788&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube：300×250（記事下）」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043107'."'".');
//]]>
</script>';


		// mobile版広告群
		$fluct_mobile_middle_1_ad_html = '<!--      Fluct グループ名「Sharetube（スマホ）_300x250_Web_インライン_ミドル_1」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027798&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube（スマホ）_300x250_Web_iOS_インライン_ミドル_1」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043122'."'".');
//]]>
</script>
<!--      Fluct ユニット名「Sharetube（スマホ）_300x250_Web_Android_インライン_ミドル_1」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043123'."'".');
//]]>
</script>';



		$fluct_mobile_middle_2_ad_html = '<!--      Fluct グループ名「Sharetube（スマホ）_300x250_Web_インライン_ミドル_2」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027799&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube（スマホ）_300x250_Web_iOS_インライン_ミドル_2」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043124'."'".');
//]]>
</script>
<!--      Fluct ユニット名「Sharetube（スマホ）_300x250_Web_Android_インライン_ミドル_2」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043125'."'".');
//]]>
</script>';


		$fluct_mobile_middle_3_ad_html = '<!--      Fluct グループ名「Sharetube（スマホ）_300x250_Web_インライン_ミドル_3」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027800&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube（スマホ）_300x250_Web_iOS_インライン_ミドル_3」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043126'."'".');
//]]>
</script>
<!--      Fluct ユニット名「Sharetube（スマホ）_300x250_Web_Android_インライン_ミドル_3」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043127'."'".');
//]]>
</script>';


		$fluct_mobile_middle_4_ad_html = '<!--      Fluct グループ名「Sharetube（スマホ）_300x250_Web_インライン_ミドル_4」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027801&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube（スマホ）_300x250_Web_iOS_インライン_ミドル_4」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043128'."'".');
//]]>
</script>
<!--      Fluct ユニット名「Sharetube（スマホ）_300x250_Web_Android_インライン_ミドル_4」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043129'."'".');
//]]>
</script>';

		$fluct_mobile_middle_5_ad_html = '<!--      Fluct グループ名「Sharetube（スマホ）_300x250_Web_インライン_ミドル_5」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027802&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube（スマホ）_300x250_Web_iOS_インライン_ミドル_5」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043130'."'".');
//]]>
</script>
<!--      Fluct ユニット名「Sharetube（スマホ）_300x250_Web_Android_インライン_ミドル_5」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043131'."'".');
//]]>
</script>';



		$fluct_mobile_middle_6_ad_html ='<!--      fluct グループ名「Sharetube（スマホ）_300x250_Web_インライン_ミドル_6」      -->
<script type="text/javascript" src="https://cdn-fluct.sh.adingo.jp/f.js?G=1000056595"></script>
<!--      fluct ユニット名「Sharetube（スマホ）_300x250_Web_iOS_インライン_ミドル_6」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000085601'."'".');
//]]>
</script>
<!--      fluct ユニット名「Sharetube（スマホ）_300x250_Web_Android_インライン_ミドル_6」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000085602'."'".');
//]]>
</script>';







		$fluct_mobile_header_ad_html = '<!--      Fluct グループ名「Sharetube（スマホ）_320x100_Web_インライン_ヘッダー_TOP」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027797&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube（スマホ）_320x100_Web_iOS_インライン_ヘッダー_TOP」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043120'."'".');
//]]>
</script>

<!--      Fluct ユニット名「Sharetube（スマホ）_320x100_Web_Android_インライン_ヘッダー_TOP」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043121'."'".');
//]]>
</script>';


		$fluct_mobile_orverlay_ad_html = '<!--      Fluct グループ名「Sharetube（スマホ）_320x50_Web_オーバーレイ」      -->
<script type="text/javascript" src="http://sh.adingo.jp/?G=1000027796&guid=ON"></script>
<!--      Fluct ユニット名「Sharetube（スマホ）_320x50_Web_iOS_オーバーレイ」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043118'."'".');
//]]>
</script>
<!--      Fluct ユニット名「Sharetube（スマホ）_320x50_Web_Android_オーバーレイ」     -->
<script type="text/javascript">
//<![CDATA[
if(typeof(adingoFluct)!="undefined") adingoFluct.showAd('."'".'1000043119'."'".');
//]]>
</script>';
		// fluct広告タグ群array
		$fluct_ad_array = array(
			'pc'     => array('サイドバー右上' => $fluct_pc_sidebar_top_ad_html, 
												'サイドバー右下' => $fluct_pc_sidebar_under_ad_html,
												'ミドル左'       => $fluct_pc_article_middle_left_ad_html,
												'ミドル右'       => $fluct_pc_article_middle_right_ad_html,	
												'記事下'         => $fluct_pc_article_under_ad_html,
												'none'           => '',
								),
			'mobile' => array('ミドル_1'     => $fluct_mobile_middle_1_ad_html, 
												'ミドル_2'     => $fluct_mobile_middle_2_ad_html, 
												'ミドル_3'     => $fluct_mobile_middle_3_ad_html, 
												'ミドル_4'     => $fluct_mobile_middle_4_ad_html, 
												'ミドル_5'     => $fluct_mobile_middle_5_ad_html, 
												'ミドル_6'     => $fluct_mobile_middle_6_ad_html, 
												'ヘッダー'     => $fluct_mobile_header_ad_html, 
												'オーバーレイ' => $fluct_mobile_orverlay_ad_html, 
												'none'         => '',
									),
		);
		// 実際に設定する場所
		if($detect->isMobile() | $detect->isTablet()) {
			switch($mobile_type) {
				case 'ミドル_1':
					$ad_html = $fluct_ad_array["mobile"]["ミドル_1"];
				break;
				case 'ミドル_2':
					$ad_html = $fluct_ad_array["mobile"]["ミドル_2"];
				break;
				case 'ミドル_3':
					$ad_html = $fluct_ad_array["mobile"]["ミドル_3"];
				break;
				case 'ミドル_4':
					$ad_html = $fluct_ad_array["mobile"]["ミドル_4"];
				break;
				case 'ミドル_5':
					$ad_html = $fluct_ad_array["mobile"]["ミドル_5"];
				break;
				case 'ミドル_6':
					$ad_html = $fluct_ad_array["mobile"]["ミドル_6"];
				break;
				case 'ヘッダー':
					$ad_html = $fluct_ad_array["mobile"]["ヘッダー"];
				break;
				case 'オーバーレイ':
					$ad_html = $fluct_ad_array["mobile"]["オーバーレイ"];
				break;
				case 'none':
					$ad_html = $fluct_ad_array["mobile"]["none"];
				break;

				default:
					$ad_html = $fluct_ad_array["mobile"]["ミドル_1"];
				break;
			}
		}
			else {
				switch($pc_type) {
					case 'サイドバー右上':
						$ad_html = $fluct_ad_array["pc"]["サイドバー右上"];
					break;
					case 'サイドバー右下':
						$ad_html = $fluct_ad_array["pc"]["サイドバー右下"];
					break;
					case 'ミドル左':
						$ad_html = $fluct_ad_array["pc"]["ミドル左"];
					break;
					case 'ミドル右':
						$ad_html = $fluct_ad_array["pc"]["ミドル右"];
					break;
					case '記事下':
						$ad_html = $fluct_ad_array["pc"]["記事下"];
					break;
					case 'none':
						$ad_html = $fluct_ad_array["pc"]["none"];
					break;
	
					default:
						$ad_html = $fluct_ad_array["pc"]["サイドバー右上"];
					break;
				}
			}
//var_dump('ああああああああああああ');
//var_dump($ad_html);
		return $ad_html;
	}
	//---------------------
	//GameFeat広告配信関数
	//---------------------
	static function GameFeat_ad_html_create($detect, $pc_type =  "サイドバー右上", $mobile_type = "ミドル_1") {
//	var_dump($pc_type);
//	var_dump($mobile_type);

		// 広告群

		$GameFeat_rectangle_ad_html = '<!-- game feat広告 -->
<script>
var _gfwebq = _gfwebq || [];
_gfwebq.push({
	site_id: 11760,p_id: "gfweb_KsaN6LDVQVU",display: "rect",order: "best",limit: "1",
});
</script>
<div id="gfweb_KsaN6LDVQVU"></div>
<script src="https://www.gamefeat.net/js/api/requestAds.v2.js"></script>';




		$GameFeat_list_ad_html = '<!-- game feat広告 -->
<script>
var _gfwebq = _gfwebq || [];
_gfwebq.push({
	site_id: 11760,p_id: "gfweb_jDkMMJevt50",display: "list",order: "best",limit: "10",s_bg_color_0: "#f7f7f7",s_bg_color_1: "#ffffff",s_txt_color: "#01a0da",s_name_color: "#333333",
});
</script>
<div id="gfweb_jDkMMJevt50"></div>
<script src="https://www.gamefeat.net/js/api/requestAds.v2.js"></script>';

		$GameFeat_ranking_ad_html = '<!-- game feat広告 -->
<script>
var _gfwebq = _gfwebq || [];
_gfwebq.push({
	site_id: 11760,p_id: "gfweb_ayZWhmGTwzq",display: "rank",order: "best",limit: "10",r_bg_color: "ffffff",r_title_bg_color: "ed482d",r_num_txt_color: "ffffff",r_txt_color: "333333",rank_type: "3",
});
</script>
<div id="gfweb_ayZWhmGTwzq"></div>
<script src="https://www.gamefeat.net/js/api/requestAds.v2.js"></script>';

		// GameFeat広告タグ群array
		$GameFeat_ad_array = array(
			'pc'     => array('サイドバー右上' => '', 
												'サイドバー右下' => '',
												'ミドル左'       => '',
												'ミドル右'       => '',	
												'記事下'         => '',
												'none'           => '',
								),
			'mobile' => array('ミドル_6'     => $GameFeat_rectangle_ad_html, 
												'ミドル_7'     => $GameFeat_rectangle_ad_html, 
												'none'         => '',
									),
		);
		if($detect->isMobile() | $detect->isTablet()) {
			switch($mobile_type) {
				case 'ミドル_6':
					$ad_html = $GameFeat_ad_array["mobile"]["ミドル_6"];
				break;
				case 'ミドル_7':
					$ad_html = $GameFeat_ad_array["mobile"]["ミドル_7"];
				break;
				case 'none':
					$ad_html = $GameFeat_ad_array["mobile"]["none"];
				break;

				default:
					$ad_html = $GameFeat_ad_array["mobile"]["ミドル_6"];
				break;
			}
		}
			else {
				$ad_html = $GameFeat_list_ad_html;
/*
				switch($pc_type) {
					default:
						$ad_html = $fluct_ad_array["pc"]["サイドバー右上"];
					break;
				}
*/
			}
//var_dump('ああああああああああああ');
//var_dump($ad_html);
		return $ad_html;
	}

	//------------------------
	//AdGeneration広告配信関数
	//------------------------
	static function AdGeneration_ad_html_create($detect, $pc_type =  "サイドバー右上", $mobile_type = "ミドル_1") {
		// 広告群
		$AdGeneration_rectangle_ad_html = '<!--
ad-generation ミドル_7 48381
-->
<script src="http://i.socdm.com/sdk/js/adg-script-loader.js?id=42481&targetID=adg_42481&displayid=3&adType=RECT&async=false&tagver=2.0.0"></script>';

		// AdGeneration広告タグ群array
		$AdGeneration_ad_array = array(
			'pc'     => array('サイドバー右上' => '', 
												'サイドバー右下' => '',
												'ミドル左'       => '',
												'ミドル右'       => '',	
												'記事下'         => '',
												'none'           => '',
								),
			'mobile' => array('ミドル_6'     => $AdGeneration_rectangle_ad_html, 
												'ミドル_7'     => $AdGeneration_rectangle_ad_html, 
												'none'         => '',
									),
		);
		if($detect->isMobile() | $detect->isTablet()) {
			switch($mobile_type) {
				case 'ミドル_6':
					$ad_html = $AdGeneration_ad_array["mobile"]["ミドル_6"];
				break;
				case 'ミドル_7':
					$ad_html = $AdGeneration_ad_array["mobile"]["ミドル_7"];
				break;
				case 'none':
					$ad_html = $AdGeneration_ad_array["mobile"]["none"];
				break;

				default:
					$ad_html = $AdGeneration_ad_array["mobile"]["ミドル_6"];
				break;
			}
		}
			else {
				$ad_html = $AdGeneration_rectangle_ad_html;
			}
		return $ad_html;
	}
	//----------------------
	//テクノアルカディア広告
	//----------------------
	public static function techno_arcadia_ad_html_create($detect, $pc_type = "サイドバー右上", $mobile_type = "ミドル_1") {
		$techno_arcadia_mobile_orverlay_ad_html = '
			<!-- テクノアルカディア広告 -->
			<script src="http://dsg.hgigs.info/js/sharetube.js" type="text/javascript" charset="utf-8"></script>';

		// テクノアルカディア広告タグ群array
		$techno_arcadia_ad_array = array(
			'pc'     => array('サイドバー右上' => '', 
												'サイドバー右下' => '',
												'ミドル左'       => '',
												'ミドル右'       => '',	
												'記事下'         => '',
												'none'           => '',
								),
			'mobile' => array('ミドル_1'     => '', 
												'ミドル_2'     => '', 
												'ミドル_3'     => '', 
												'ミドル_4'     => '', 
												'ミドル_5'     => '', 
												'ヘッダー'     => '', 
												'オーバーレイ' => $techno_arcadia_mobile_orverlay_ad_html, 
												'none'         => '',
									),
		);
//		var_dump($techno_arcadia_ad_array);
		if($detect->isMobile() | $detect->isTablet()) {
			switch($mobile_type) {
				case 'ミドル_1':
					$ad_html = $techno_arcadia_ad_array["mobile"]["ミドル_1"];
				break;
				case 'ミドル_2':
					$ad_html = $techno_arcadia_ad_array["mobile"]["ミドル_2"];
				break;
				case 'ミドル_3':
					$ad_html = $techno_arcadia_ad_array["mobile"]["ミドル_3"];
				break;
				case 'ミドル_4':
					$ad_html = $techno_arcadia_ad_array["mobile"]["ミドル_4"];
				break;
				case 'ミドル_5':
					$ad_html = $techno_arcadia_ad_array["mobile"]["ミドル_5"];
				break;
				case 'ヘッダー':
					$ad_html = $techno_arcadia_ad_array["mobile"]["ヘッダー"];
				break;
				case 'オーバーレイ':
					$ad_html = $techno_arcadia_ad_array["mobile"]["オーバーレイ"];
				break;
				case 'none':
					$ad_html = $techno_arcadia_ad_array["mobile"]["none"];
				break;

				default:
					$ad_html = $techno_arcadia_ad_array["mobile"]["ミドル_1"];
				break;
			}
		}
			else {
				switch($pc_type) {
					case 'サイドバー右上':
						$ad_html = $techno_arcadia_ad_array["pc"]["サイドバー右上"];
					break;
					case 'サイドバー右下':
						$ad_html = $techno_arcadia_ad_array["pc"]["サイドバー右下"];
					break;
					case 'ミドル左':
						$ad_html = $techno_arcadia_ad_array["pc"]["ミドル左"];
					break;
					case 'ミドル右':
						$ad_html = $techno_arcadia_ad_array["pc"]["ミドル右"];
					break;
					case '記事下':
						$ad_html = $techno_arcadia_ad_array["pc"]["記事下"];
					break;
					case 'none':
						$ad_html = $techno_arcadia_ad_array["pc"]["none"];
					break;
	
					default:
						$ad_html = $techno_arcadia_ad_array["pc"]["サイドバー右上"];
					break;
				}
			}
		return $ad_html;
	}
	//----------------
	//広告指定配信関数
	//----------------
	public static function ad_html_create($detect, $ad_network = 'i-mobile', $type = 'レクタングル') {

		// fluctの広告array
		$fluct_array = array();

		// genieeの広告array
		$geniee_rectangle_array = array(
			'mobile' => '<!--  ad tags Size: 300x250 ZoneId:1003045-->
		<script type="text/javascript" src="http://101058.gsspcln.jp/t/003/045/a1003045.js"></script>
		', 
			'tablet' => '<!--  ad tags Size: 300x250 ZoneId:1003045-->
		<script type="text/javascript" src="http://101058.gsspcln.jp/t/003/045/a1003045.js"></script>
		', 
			'pc'     => '<!--  ad tags Size: 300x250 ZoneId:1003045-->
		<script type="text/javascript" src="http://101058.gsspcln.jp/t/003/045/a1003045.js"></script>
		', 
		);

		// i-modeの広告big_banner_array
		$imobile_sp_big_banner_array = array(
			'mobile' => '<!-- i-mobile for SmartPhone client script -->
	<script type="text/javascript">
	    imobile_tag_ver = "0.2"; 
	    imobile_pid = "33539"; 
	    imobile_asid = "309667"; 
	    imobile_type = "inline";
	</script>
	<script type="text/javascript" src="http://spad.i-mobile.co.jp/script/adssp.js?20110215"></script>',);
	
		// i-modeの広告rectangle_array
		$imobile_rectangle_array = array(
			'mobile' => '<!-- i-mobile for SmartPhone client script -->
	<script type="text/javascript">
	    imobile_tag_ver = "0.2"; 
	    imobile_pid = "33539"; 
	    imobile_asid = "309666"; 
	    imobile_type = "inline";
	</script>
	<script type="text/javascript" src="http://spad.i-mobile.co.jp/script/adssp.js?20110215"></script>
	',
			'tablet' => '<!-- i-mobile for SmartPhone client script -->
	<script type="text/javascript">
	    imobile_tag_ver = "0.2"; 
	    imobile_pid = "33539"; 
	    imobile_asid = "309666"; 
	    imobile_type = "inline";
	</script>
	<script type="text/javascript" src="http://spad.i-mobile.co.jp/script/adssp.js?20110215"></script>
	',
			'pc'     => '<!-- i-mobile for PC client script -->
	<script type="text/javascript">
	    imobile_pid = "33539"; 
	    imobile_asid = "309696"; 
	    imobile_width = 300; 
	    imobile_height = 250;
	</script>
	<script type="text/javascript" src="http://spdeliver.i-mobile.co.jp/script/ads.js?20101001"></script>',);







		if($ad_network == 'i-mobile') {
			if($detect->isMobile()) {
				switch($type) {
					case 'レクタングル':
						$ad_html = $imobile_rectangle_array["mobile"];
					break;
					case 'スマートフォンビッグバナー':
					 $ad_html = $imobile_sp_big_banner_array["mobile"];
					break;
		
					default:
						$ad_html = $imobile_rectangle_array["mobile"];
					break;
				}
			}
				else if($detect->isTablet()) {
	
				}
					else {
						switch($type) {
							case 'レクタングル':
								$ad_html = $imobile_rectangle_array["pc"];
							break;
	
							default:
							 $ad_html = $imobile_rectangle_array["pc"];
							break;
						}
					}
		} // if($ad_network == 'i-mobile') {
			else if($ad_network == 'geniee') {
				if($detect->isMobile()) {
					switch($type) {
						case 'レクタングル':
							$ad_html = $geniee_rectangle_array["mobile"];
						break;
						default:
							$ad_html = $geniee_rectangle_array["mobile"];
						break;
					}
				}
					else if($detect->isTablet()) {
		
					}
						else {
							switch($type) {
								case 'レクタングル':
									$ad_html = $geniee_rectangle_array["pc"];
								break;

								default:
								 $ad_html = $geniee_rectangle_array["pc"];
								break;
							}
						}
			} // else if($ad_network == 'geniee') {
		return $ad_html;
	}
}
?>
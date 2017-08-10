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
//	pre_var_dump($pc_type);
//	pre_var_dump($mobile_type);

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
	//---------------------
	//全ての広告別array取得
	//---------------------
	public static function all_ad_html_array_get() {
		///////
		//fluct
		///////
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

$fluct_mobile_relation_ad_html = '';

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

$fluct_mobile_infeed_ad_html = '';
$fluct_mobile_interstitial_ad_html = '';

////////
//geniee
////////
// pc
$geniee_pc_sidebar_top_ad_html          = '';
$geniee_pc_sidebar_under_ad_html        = '';
$geniee_pc_article_middle_left_ad_html  = '';
$geniee_pc_article_middle_right_ad_html = '';
$geniee_pc_article_under_ad_html        = '';

// mobile
$geniee_mobile_middle_1_ad_html         = '<!--  ad tags Size: 300x250 ZoneId:1197388-->
<script type="text/javascript" src="http://js.gsspcln.jp/t/197/388/a1197388.js"></script>';
$geniee_mobile_middle_2_ad_html         = '<!--  ad tags Size: 300x250 ZoneId:1202031-->
<script type="text/javascript" src="http://js.gsspcln.jp/t/202/031/a1202031.js"></script>';
$geniee_mobile_middle_3_ad_html         = '<!--  ad tags Size: 300x250 ZoneId:1202032-->
<script type="text/javascript" src="http://js.gsspcln.jp/t/202/032/a1202032.js"></script>';
$geniee_mobile_middle_4_ad_html         = '<!--  ad tags Size: 300x250 ZoneId:1202034-->
<script type="text/javascript" src="http://js.gsspcln.jp/t/202/034/a1202034.js"></script>';
$geniee_mobile_middle_5_ad_html         = '<!--  ad tags Size: 300x250 ZoneId:1202035-->
<script type="text/javascript" src="http://js.gsspcln.jp/t/202/035/a1202035.js"></script>';
$geniee_mobile_middle_6_ad_html         = '<!--  ad tags Size: 300x250 ZoneId:1202036-->
<script type="text/javascript" src="http://js.gsspcln.jp/t/202/036/a1202036.js"></script>';
$geniee_mobile_relation_ad_html         = '';
$geniee_mobile_header_ad_html           = '';
$geniee_mobile_infeed_ad_html           = '<!--  ad tags Size: 0x0 ZoneId:1202037-->
<script type="text/javascript" src="http://js.gsspcln.jp/t/202/037/a1202037.js"></script>';
$geniee_mobile_interstitial_ad_html     = '<!--  ad tags Size: 300x250 ZoneId:1197383-->
<script type="text/javascript" src="http://js.gsspcln.jp/t/197/383/a1197383.js"></script>';
$geniee_mobile_orverlay_ad_html         = '<!--  ad tags Size: 320x50 ZoneId:1197386-->
<script type="text/javascript" src="http://js.gsspcln.jp/t/197/386/a1197386.js"></script>';
//////////////
//アドウェイズ
//////////////
// pc
$addways_pc_sidebar_top_ad_html          = '';
$addways_pc_sidebar_under_ad_html        = '';
$addways_pc_article_middle_left_ad_html  = '';
$addways_pc_article_middle_right_ad_html = '';
$addways_pc_article_under_ad_html        = '';

// mobile
$addways_mobile_middle_1_ad_html         = '<script type="text/javascript">
<!--
try{var __dj800hqatprzyvei_arr=[];var __dj800hqatprzyvei_prepare=function(h){__dj800hqatprzyvei_arr.push(h);};var __dj800hqatprzyvei_xhr = new XMLHttpRequest();__dj800hqatprzyvei_xhr.timeout=5000;__dj800hqatprzyvei_xhr.open("GET","//js.oct-pass.net/dj800hqatprzyvei/?async=1&js=1&_t="+(new Date().getTime()),true);__dj800hqatprzyvei_xhr.onreadystatechange = function(){if (__dj800hqatprzyvei_xhr.readyState == 4 && (__dj800hqatprzyvei_xhr.status == 200 || __dj800hqatprzyvei_xhr.status == 201))eval(__dj800hqatprzyvei_xhr.responseText);};__dj800hqatprzyvei_xhr.send(null);}catch(err){};
// -->
</script>
<span id="__dj800hqatprzyvei" style="display:none"></span>';
$addways_mobile_middle_2_ad_html         = '';
$addways_mobile_middle_3_ad_html         = '';
$addways_mobile_middle_4_ad_html         = '';
$addways_mobile_middle_5_ad_html         = '';
$addways_mobile_middle_6_ad_html         = '';
$addways_mobile_relation_ad_html         = '';
$addways_mobile_header_ad_html           = '';
$addways_mobile_infeed_ad_html           = '';
$addways_mobile_interstitial_ad_html     = '';
$addways_mobile_orverlay_ad_html         = '';
//////////////
//マーベリック
//////////////
// pc
$maverick_pc_sidebar_top_ad_html          = '';
$maverick_pc_sidebar_under_ad_html        = '';
$maverick_pc_article_middle_left_ad_html  = '';
$maverick_pc_article_middle_right_ad_html = '';
$maverick_pc_article_under_ad_html        = '';

// mobile
$maverick_mobile_middle_1_ad_html         = '';
$maverick_mobile_middle_2_ad_html         = '';
$maverick_mobile_middle_3_ad_html         = '';
$maverick_mobile_middle_4_ad_html         = '';
$maverick_mobile_middle_5_ad_html         = '';
$maverick_mobile_middle_6_ad_html         = '';
$maverick_mobile_relation_ad_html         = '';
$maverick_mobile_header_ad_html           = '';
$maverick_mobile_infeed_ad_html           = '<div class="cirqua-slot" data-slot-id="QpZNOUaN" style="display:none"></div>
<script src="https://crs.adapf.com/cirqua.js?id=NhzchTxI" id="cirqua-jssdk"></script>';
$maverick_mobile_interstitial_ad_html     = '';
$maverick_mobile_orverlay_ad_html         = '';

		// 広告タグ群array作成
		$all_ad_html_array = array(
			'fluct' => array(
				'pc' => array(
					'サイドバー右上' => $fluct_pc_sidebar_top_ad_html, 
					'サイドバー右下' => $fluct_pc_sidebar_under_ad_html,
					'ミドル左'       => $fluct_pc_article_middle_left_ad_html,
					'ミドル右'       => $fluct_pc_article_middle_right_ad_html,	
					'記事下'         => $fluct_pc_article_under_ad_html,
					'none'           => '',
				),
				'mobile' => array(
					'ミドル_1'             => $fluct_mobile_middle_1_ad_html, 
					'ミドル_2'             => $fluct_mobile_middle_2_ad_html, 
					'ミドル_3'             => $fluct_mobile_middle_3_ad_html, 
					'ミドル_4'             => $fluct_mobile_middle_4_ad_html, 
					'ミドル_5'             => $fluct_mobile_middle_5_ad_html, 
					'ミドル_6'             => $fluct_mobile_middle_6_ad_html, 
					'記事中関連記事'       => $fluct_mobile_relation_ad_html, 
					'ヘッダー'             => $fluct_mobile_header_ad_html, 
					'インフィード'         => $fluct_mobile_infeed_ad_html,
					'オーバーレイ'         => $fluct_mobile_orverlay_ad_html, 
					'インタースティシャル' => $fluct_mobile_interstitial_ad_html,
				),
			),
			'geniee' => array(
				'pc' => array(
					'サイドバー右上' => $geniee_pc_sidebar_top_ad_html, 
					'サイドバー右下' => $geniee_pc_sidebar_under_ad_html,
					'ミドル左'       => $geniee_pc_article_middle_left_ad_html,
					'ミドル右'       => $geniee_pc_article_middle_right_ad_html,	
					'記事下'         => $geniee_pc_article_under_ad_html,
					'none'           => '',
				),
				'mobile' => array(
					'ミドル_1'             => $geniee_mobile_middle_1_ad_html, 
					'ミドル_2'             => $geniee_mobile_middle_2_ad_html, 
					'ミドル_3'             => $geniee_mobile_middle_3_ad_html, 
					'ミドル_4'             => $geniee_mobile_middle_4_ad_html, 
					'ミドル_5'             => $geniee_mobile_middle_5_ad_html, 
					'ミドル_6'             => $geniee_mobile_middle_6_ad_html, 
					'記事中関連記事'       => $geniee_mobile_relation_ad_html, 
					'ヘッダー'             => $geniee_mobile_header_ad_html, 
					'インフィード'         => $geniee_mobile_infeed_ad_html,
					'オーバーレイ'         => $geniee_mobile_orverlay_ad_html, 
					'インタースティシャル' => $geniee_mobile_interstitial_ad_html,
				),
			),
			'i-mode' => array(
				'pc' => array(
					'サイドバー右上' => $imode_pc_sidebar_top_ad_html, 
					'サイドバー右下' => $imode_pc_sidebar_under_ad_html,
					'ミドル左'       => $imode_pc_article_middle_left_ad_html,
					'ミドル右'       => $imode_pc_article_middle_right_ad_html,	
					'記事下'         => $imode_pc_article_under_ad_html,
					'none'           => '',
				),
				'mobile' => array(
					'ミドル_1'             => $imode_mobile_middle_1_ad_html, 
					'ミドル_2'             => $imode_mobile_middle_2_ad_html, 
					'ミドル_3'             => $imode_mobile_middle_3_ad_html, 
					'ミドル_4'             => $imode_mobile_middle_4_ad_html, 
					'ミドル_5'             => $imode_mobile_middle_5_ad_html, 
					'ミドル_6'             => $imode_mobile_middle_6_ad_html, 
					'記事中関連記事'       => $imode_mobile_relation_ad_html, 
					'ヘッダー'             => $imode_mobile_header_ad_html, 
					'インフィード'         => $imode_mobile_infeed_ad_html,
					'オーバーレイ'         => $imode_mobile_orverlay_ad_html, 
					'インタースティシャル' => $imode_mobile_interstitial_ad_html,
				),
			),
			'maverick' => array(
				'pc' => array(
					'サイドバー右上' => $maverick_pc_sidebar_top_ad_html, 
					'サイドバー右下' => $maverick_pc_sidebar_under_ad_html,
					'ミドル左'       => $maverick_pc_article_middle_left_ad_html,
					'ミドル右'       => $maverick_pc_article_middle_right_ad_html,	
					'記事下'         => $maverick_pc_article_under_ad_html,
					'none'           => '',
				),
				'mobile' => array(
					'ミドル_1'             => $maverick_mobile_middle_1_ad_html, 
					'ミドル_2'             => $maverick_mobile_middle_2_ad_html, 
					'ミドル_3'             => $maverick_mobile_middle_3_ad_html, 
					'ミドル_4'             => $maverick_mobile_middle_4_ad_html, 
					'ミドル_5'             => $maverick_mobile_middle_5_ad_html, 
					'ミドル_6'             => $maverick_mobile_middle_6_ad_html, 
					'記事中関連記事'       => $maverick_mobile_relation_ad_html, 
					'ヘッダー'             => $maverick_mobile_header_ad_html, 
					'インフィード'         => $maverick_mobile_infeed_ad_html,
					'オーバーレイ'         => $maverick_mobile_orverlay_ad_html, 
					'インタースティシャル' => $maverick_mobile_interstitial_ad_html,
				),
			),
			'addways' => array(
				'pc' => array(
					'サイドバー右上' => $addways_pc_sidebar_top_ad_html, 
					'サイドバー右下' => $addways_pc_sidebar_under_ad_html,
					'ミドル左'       => $addways_pc_article_middle_left_ad_html,
					'ミドル右'       => $addways_pc_article_middle_right_ad_html,	
					'記事下'         => $addways_pc_article_under_ad_html,
					'none'           => '',
				),
				'mobile' => array(
					'ミドル_1'             => $addways_mobile_middle_1_ad_html, 
					'ミドル_2'             => $addways_mobile_middle_2_ad_html, 
					'ミドル_3'             => $addways_mobile_middle_3_ad_html, 
					'ミドル_4'             => $addways_mobile_middle_4_ad_html, 
					'ミドル_5'             => $addways_mobile_middle_5_ad_html, 
					'ミドル_6'             => $addways_mobile_middle_6_ad_html, 
					'記事中関連記事'       => $addways_mobile_relation_ad_html, 
					'ヘッダー'             => $addways_mobile_header_ad_html, 
					'インフィード'         => $addways_mobile_infeed_ad_html,
					'オーバーレイ'         => $addways_mobile_orverlay_ad_html, 
					'インタースティシャル' => $addways_mobile_interstitial_ad_html,
				),
			),
		);
		return $all_ad_html_array;
	}
	//--------------------------------
	//広告ネットワーク指定アドhtml生成
	//--------------------------------
	public static function all_ad_html_create($all_ad_html_array, $detect, $pc_ad_network = 'fluct', $mobile_ad_network = 'fluct', $pc_type =  'サイドバー右上', $mobile_type = 'ミドル_1') {
		// 実際に設定する場所
		if($detect->isMobile() | $detect->isTablet()) {
			switch($mobile_type) {
				case 'ミドル_1':
					$ad_html = $all_ad_html_array[$mobile_ad_network]["mobile"]["ミドル_1"];
				break;
				case 'ミドル_2':
					$ad_html = $all_ad_html_array[$mobile_ad_network]["mobile"]["ミドル_2"];
				break;
				case 'ミドル_3':
					$ad_html = $all_ad_html_array[$mobile_ad_network]["mobile"]["ミドル_3"];
				break;
				case 'ミドル_4':
					$ad_html = $all_ad_html_array[$mobile_ad_network]["mobile"]["ミドル_4"];
				break;
				case 'ミドル_5':
					$ad_html = $all_ad_html_array[$mobile_ad_network]["mobile"]["ミドル_5"];
				break;
				case 'ミドル_6':
					$ad_html = $all_ad_html_array[$mobile_ad_network]["mobile"]["ミドル_6"];
				break;
				case '記事中関連記事':
					$ad_html = $all_ad_html_array[$mobile_ad_network]["mobile"]["記事中関連記事"];
				break;
				case 'ヘッダー':
					$ad_html = $all_ad_html_array[$mobile_ad_network]["mobile"]["ヘッダー"];
				break;
				case 'インフィード':
					$ad_html = $all_ad_html_array[$mobile_ad_network]["mobile"]["インフィード"];
				break;
				case 'オーバーレイ':
					$ad_html = $all_ad_html_array[$mobile_ad_network]["mobile"]["オーバーレイ"];
				break;
				case 'インタースティシャル':
					$ad_html = $all_ad_html_array[$mobile_ad_network]["mobile"]["インタースティシャル"];
				break;
				case 'none':
					$ad_html = $all_ad_html_array[$mobile_ad_network]["mobile"]["none"];
				break;

				default:
					$ad_html = $all_ad_html_array[$mobile_ad_network]["mobile"]["ミドル_1"];
				break;
			}
		}
			else {
				switch($pc_type) {
					case 'サイドバー右上':
						$ad_html = $all_ad_html_array[$pc_ad_network]["pc"]["サイドバー右上"];
					break;
					case 'サイドバー右下':
						$ad_html = $all_ad_html_array[$pc_ad_network]["pc"]["サイドバー右下"];
					break;
					case 'ミドル左':
						$ad_html = $all_ad_html_array[$pc_ad_network]["pc"]["ミドル左"];
					break;
					case 'ミドル右':
						$ad_html = $all_ad_html_array[$pc_ad_network]["pc"]["ミドル右"];
					break;
					case '記事下':
						$ad_html = $all_ad_html_array[$pc_ad_network]["pc"]["記事下"];
					break;
					case 'none':
						$ad_html = $all_ad_html_array[$pc_ad_network]["pc"]["none"];
					break;
	
					default:
						$ad_html = $all_ad_html_array[$pc_ad_network]["pc"]["サイドバー右上"];
					break;
				}
			}
		return $ad_html;
	}







}
?>
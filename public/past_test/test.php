<?php 
// エラー回避
error_reporting(0);
ini_set('display_errors', 1);

/**
 * ローカルと本番環境のpathを吸収
 */
// ローカル環境
//if($_SERVER["HTTP_HOST"] == 'localhost') {
if(preg_match('/localhost/',$_SERVER["HTTP_HOST"])) {
	// デフォルト変数生成
	define('HTTP', 'http://localhost/sharetube/');
	define('PATH', '/Volumes/2016_ssd_media'.$_SERVER["DOCUMENT_ROOT"].'/sharetube/');
	define('INTERNAL_PATH', str_replace('sharetube/', '', PATH).'fuelphp/sharetube/');
	define('TITLE', 'Sharetube - シェアしたくなるコンテンツが集まる、集まる。');
	define('META_KEYWORDS', 'Sharetube,シェアチューブ,まとめ,キュレーション,キュレーター,インセンティブ');
	define('META_DESCRIPTION', 'Sharetubeはシェアしたくなるコンテンツが集まる場所。情報をデザインしてオリジナルのコンテンツをアップロードして身近な人やインターネットの人たちと共有しましょう。');
	define('TWITTER_ID', 'ShareTube_jp');
}
	// 本番環境
	else {
		// デフォルト変数生成
		define('HTTP', 'http://'.$_SERVER["HTTP_HOST"].'/');
		define('PATH', $_SERVER["DOCUMENT_ROOT"].'/');
		define('INTERNAL_PATH', str_replace('public/', '', PATH));
		define('TITLE', 'Sharetube - シェアしたくなるコンテンツが集まる、集まる。');
		define('META_KEYWORDS', 'Sharetube,シェアチューブ,まとめ,キュレーション,キュレーター,インセンティブ');
		define('META_DESCRIPTION', 'Sharetubeはシェアしたくなるコンテンツが集まる場所。情報をデザインしてオリジナルのコンテンツをアップロードして身近な人やインターネットの人たちと共有しましょう。');
		define('TWITTER_ID', 'ShareTube_jp');
	}

class Model
{

}
// 必要なクラス群を読み込み
require INTERNAL_PATH.'fuel/app/classes/model/info/basis.php';
require INTERNAL_PATH.'fuel/app/classes/model/ad/html.php';
require INTERNAL_PATH.'fuel/app/classes/model/ad/basis.php';







?><!DOCTYPE html>
<html>
	<head>
		<title>Sharetube - シェアしたくなるコンテンツが集まる、集まる。</title>
		<!-- meta -->
		
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
				<!-- icon -->
		<link rel="shortcut icon" href="http://sharetube.jp/assets/img/icon/favicon_5.ico" type="image/vnd.microsoft.icon">



		<!-- rss -->
		<link rel="alternate" type="application/rss+xml" title="Sharetube RSSフィード" href="http://sharetube.jp/feed.xml">
		<!-- css -->
		<link rel="stylesheet" href="http://sharetube.jp/assets/css/common/common.css" type="text/css">
		<link rel="stylesheet" href="http://sharetube.jp/assets/css/matome/common.css" type="text/css">
		<link rel="stylesheet" href="http://sharetube.jp/assets/css/library/typicons.2.0.7/font/typicons.css" type="text/css">
		<link rel="stylesheet" href="http://sharetube.jp/assets/css/library/flickity.1.1.1/flickity.css" type="text/css" media="screen">
		<link rel="stylesheet" href="http://sharetube.jp/assets/js/library/flexslider.2/flexslider.css" type="text/css" media="screen">
		<link rel="apple-touch-icon" href="http://sharetube.jp/assets/img/icon/apple_touch_icon_1.png" />
		<link rel="apple-touch-icon-precomposed" href="http://sharetube.jp/assets/img/icon/apple_touch_icon_1.png" />

		
<link rel="stylesheet" href="http://sharetube.jp/assets/css/library/typicons.2.0.7/font/typicons.css" type="text/css">
<link rel="stylesheet" href="http://sharetube.jp/assets/css/article/common.css" type="text/css">
<link rel="stylesheet" href="http://sharetube.jp/assets/library/sweetalert-master/dist/sweetalert.css" type="text/css">	</head>
	<body>
		<!-- wrapper -->
		<div id="wrapper">
			<!-- header -->
			




			<!-- top_header -->
			<div class="top_header clearfix">
				<div class="top_header_contents">
					<div class="top_header_contents_left">
						<ul>
							<li> </li>
						</ul>
					</div>
					<div class="top_header_contents_righr">
					
					</div>
				</div>
			</div> <!-- top_header -->
			<!-- all_header_ad -->
					<!-- header -->
		<header id="header" class="clearfix">
			<div class="header_contents clearfix">
				<!-- logo -->
				<div class="logo">
					<h1>
						<a class="o_8" href="http://sharetube.jp/"><img src="http://sharetube.jp/assets/img/logo/logo_29.png" width="135" height="36" alt="シェアチューブ" title="シェアチューブ"></a>
					</h1>
<!--
					<h2 style="font-size: 75%; margin: -1px 0px 0px;">情報をお洒落にするメディア</h2>
-->
				</div>
				<!-- header_box_navi -->
				<div class="header_box_navi">
					<ul>
<!--
						<li class="navi_items">
							<span><a href="http://sharetube.jp/about/">アバウト</a></span>
						</li>
-->
						<li class="navi_items">
							<span class="trigger_category">カテゴリ</span>
							<!-- category_nav -->
							<div class="category_nav">
								<ul class="">
									<li><a href="http://sharetube.jp/entertainment_culture/">エンタメ・カルチャー</a></li>
									<li><a href="http://sharetube.jp/news_gossip/">ニュース・ゴシップ</a></li>
									<li><a href="http://sharetube.jp/cute/">かわいい</a></li>
									<li><a href="http://sharetube.jp/girls/">ガールズ</a></li>
									<li><a href="http://sharetube.jp/life_idea/">暮らし・アイデア</a></li>
									<li><a href="http://sharetube.jp/body/">カラダ</a></li>
									<li><a href="http://sharetube.jp/spot_gourmet/">おでかけ・グルメ</a></li>
									<li><a href="http://sharetube.jp/recipe/">レシピ</a></li>
								</ul>
								<ul class="" style="width: 241px;">
									<li><a href="http://sharetube.jp/humor/">おもしろ</a></li>
									<li><a href="http://sharetube.jp/anime_game/">アニメ・ゲーム</a></li>
									<li><a href="http://sharetube.jp/app_gadget/">アプリ・ガジェット</a></li>
									<li><a href="http://sharetube.jp/design_art/">デザイン・アート</a></li>
									<li><a href="http://sharetube.jp/developer_programming/">開発・プログラミング</a></li>
									<li><a href="http://sharetube.jp/innovation_technology/">イノベーション・テクノロジー</a></li>
									<li><a href="http://sharetube.jp/business_startup/">ビジネス・スタートアップ</a></li>
									<li><a href="http://sharetube.jp/notice/">お知らせ</a></li>
								</ul>
							</div>
						</li>
						<li class="navi_items">
							<span><a href="http://sharetube.jp/signup/">まとめ作成</a></span>
						</li>
						<li class="navi_items">
							<span><a href="http://sharetube.jp/login/">ログイン</a></span>
						</li>
						<li class="navi_items">
							<span><a target="blank" href="http://sharetube.jp/contact/">お問い合わせ</a></span>
						</li>
						<li class="navi_items">
							<div class="fb-like" data-href="https://www.facebook.com/sharetube.jp/" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
						</li>
					</ul>
				</div>
				<!-- nav -->
				<nav class="nav">
					<ul class="clearfix">
						<li><a><img src="http://sharetube.jp/assets/img/common/navi_icon_4.png" width="30" height="19" alt="about_icon"></a></li>
					</ul>
				</nav>
				<!-- search_window -->
				<nav class="search_window">
					<form method="post" action="http://sharetube.jp/search/" class="search_window_form">
						<input type="text" placeholder="気になったキーワードを検索" value="" name="search" id="search">
						<input type="submit" value="検索" name="submit" id="submit">
					</form>
				</nav>
			</div> <!-- header_contents -->

			<!-- scroll_data_view(デバッグ用) -->
<!--
			<style>
			.scroll_data_view {
				position: fixed;
			}
			</style>
			<div class="scroll_data_view">表示</div>
-->
		</header>
			<!-- セカンドナビ -->
			<section class="second_navi">
				<div class="second_navi_contents">
<!--
				  <h2>シェアチューブはキュレーターを募集しています！</h2>
-->
				  <ul>
				  	<li><a target="_blank" href="https://www.facebook.com/sharetube.jp/"><img width="30" height="30" src="http://sharetube.jp/assets/img/common/new_facebook_icon_1.png" alt="" title="Facebook"></a></li>
				  	<li><a target="_blank" href="https://twitter.com/Sharetube_jp"><img width="30" height="30" src="http://sharetube.jp/assets/img/common/new_twitter_icon_1.png" alt="" title="Twitter"></a></li>
				  	<li><a target="_blank" href="https://plus.google.com/+SharetubeJp0480"><img width="30" height="30" src="http://sharetube.jp/assets/img/common/google+_icon_2.png" alt="" title="Google+"></a></li>
				  	<li><a href="http://sharetube.jp/feed.xml"><img width="30" height="30" src="http://sharetube.jp/assets/img/common/new_rss_icon_1.png" alt="" title="RSS"></a></li>
				  	<li><a href='http://cloud.feedly.com/#subscription%2Ffeed%2Fhttp%3A%2F%2Fsharetube.jp%2Ffeed.xml'  target='blank'><img id='feedlyFollow' src='http://s3.feedly.com/img/follows/feedly-follow-rectangle-flat-medium_2x.png' alt='follow us in feedly' width='71' height='28'></a></li>
				  </ul>
				</div>
			</section>
			<!-- スクロールトップ -->
			<div class="scroll_top o_8">
				<img width="48" height="48" alt="scroll_icon" title="一番上に移動" src="http://sharetube.jp/assets/img/common/scroll_top_7.png">
			</div>
			<!-- シャッフルボタン -->
			<div class="shuffle_button o_8">
				<a href="">
				<img width="52" height="48" alt="shuffle_button" title="ページをシャッフル" src="http://sharetube.jp/assets/img/common/shuffle_button_4.png">
				</a>
			</div>
								<!-- 目次へ移動ボタン -->
					<div class="contents_button o_8">
						<img width="52" height="48" alt="contents_button" title="目次へ移動" src="http://sharetube.jp/assets/img/common/scroll_index_2.png">
					</div>
								<!-- mobile_ad -->
			<?php 
		// 広告配信
		$detect  = Model_info_Basis::mobile_detect_create();
		// Fluct広告
//		$ad_mobile_deader_html   = Model_Ad_Html::fluct_ad_html_create($detect, "none", "ヘッダー");
//		$ad_mobile_orverlay_html = Model_Ad_Html::fluct_ad_html_create($detect, "none", "オーバーレイ");

		// 全ての広告別array取得
		$all_ad_html_array = Model_Ad_Html::all_ad_html_array_get();
		// アドネットワークをランダムで取得
		$ad_network_name = Model_Ad_Basis::ad_network_random_get(array("fluct", "geniee"));
		// 広告ネットワーク指定アドhtml生成
		$ad_mobile_orverlay_html   = Model_Ad_Html::all_ad_html_create($all_ad_html_array, $detect, "fluct", $ad_network_name, "none", "オーバーレイ");

		// 記事内トップ広告分け
		// モバイル
		if($detect->isMobile()) {
			// ヘッダー
			$ad_mobile_deader_html = 
			'<div class="mobile_header_ad">
				<div class="mobile_header_ad_content">
					'.$ad_mobile_deader_html.'
				</div>
			</div>';
			// オーバーレイ
			$ad_mobile_orverlay_html = 
				'<div class="mobile_orverlay_ad">
					<div class="mobile_orverlay_ad_content">
						'.$ad_mobile_orverlay_html.'
					</div>
				</div>';
		}
			// タブレット
			else if($detect->isTablet()) {
				$ad_mobile_deader_html = 
				'<div class="mobile_header_ad">
					<div class="mobile_header_ad_content">
	
					</div>
				</div>';

			// オーバーレイ
			$ad_mobile_orverlay_html = 
				'<div class="mobile_orverlay_ad">
					<div class="mobile_orverlay_ad_content">
						'.$ad_mobile_orverlay_html.'
					</div>
				</div>';
			}
			// PC(初期化)
				else {
					$ad_mobile_deader_html = 
					'<div class="mobile_header_ad">
						<div class="mobile_header_ad_content">
		
						</div>
					</div>';

					$ad_mobile_orverlay_html = 
					'<div class="mobile_orverlay_ad">
						<div class="mobile_orverlay_ad_content">
							
						</div>
					</div>';
				}
			echo $ad_mobile_deader_html;
			echo $ad_mobile_orverlay_html;
?>			<!-- drawer -->
							<!-- drawer_nav -->
				<nav class="drawer_nav clearfix">
					<ol>
						<!-- 検索 -->
						<li class="li_clear">
							<dl>
								<dt></dt>
								<dd>
									<form method="post" action="http://sharetube.jp/search/" class="search_form">
										<input type="text" placeholder="検索" value="" name="search" id="search">
									</form>
								</dd>
							</dl>
						</li>
						<!-- Vine版 -->
<!--
						<li class="li_clear">
							<dl>
								<dt>Vine版</dt>
								<dd>
									<ul>
										<li><a href="http://sharetube.jp/vine/">Sharetube@Vine</a></li>
									</ul>
								</dd>
							</dl>
						</li>
-->
						<!-- カテゴリー -->
						<li class="li_clear">
							<dl>
								<dt>カテゴリー</dt>
								<dd>
									<ul>
										<li><a href="http://sharetube.jp/entertainment_culture/">エンタメ・カルチャー</a></li>
										<li><a href="http://sharetube.jp/news_gossip/">ニュース・ゴシップ</a></li>
										<li><a href="http://sharetube.jp/cute/">かわいい</a></li>
										<li><a href="http://sharetube.jp/girls/">ガールズ</a></li>
										<li><a href="http://sharetube.jp/life_idea/">暮らし・アイデア</a></li>
										<li><a href="http://sharetube.jp/body/">カラダ</a></li>
										<li><a href="http://sharetube.jp/spot_gourmet/">おでかけ・グルメ</a></li>
										<li><a href="http://sharetube.jp/recipe/">レシピ</a></li>
										<li><a href="http://sharetube.jp/humor/">おもしろ</a></li>
										<li><a href="http://sharetube.jp/anime_game/">アニメ・ゲーム</a></li>
										<li><a href="http://sharetube.jp/app_gadget/">アプリ・ガジェット</a></li>
										<li><a href="http://sharetube.jp/design_art/">デザイン・アート</a></li>
										<li><a href="http://sharetube.jp/developer_programming/">開発・プログラミング</a></li>
										<li><a href="http://sharetube.jp/innovation_technology/">イノベーション・テクノロジー</a></li>
										<li><a href="http://sharetube.jp/business_startup/">ビジネス・スタートアップ</a></li>
										<li><a href="http://sharetube.jp/notice/">お知らせ</a></li>
									</ul>
								</dd>
							</dl>
						</li>
						<!-- about -->
						<li class="li_clear">
							<dl>
								<dt>about</dt>
								<dd>
									<ul>
										<li><a href="http://sharetube.jp/about/">Sharetubeについて</a></li>
										<li><a href="http://sharetube.jp/rule/rule">利用規約</a></li>
										<li><a href="http://sharetube.jp/contact/">お問い合わせ</a></li>
										<li><a href="http://sharetube.jp/sitemap/">サイトマップ</a></li>
										<li><a href="http://sharetube.jp/permalink/recruitment_ads.php">広告掲載について</a></li>
										<li><a href="http://sharetube.jp/signup/">まとめ作成</a></li>
										<li><a href="http://sharetube.jp/signup/">Sharetubeアカウント作成</a></li>
										<li><a href="http://sharetube.jp/login/" target="_blank">ログイン</a></li>
										<li><a href="http://sharetube.jp/curatorrecruitment/">キュレーター募集</a></li>
										<li><a href="http://sharetube.jp/curatorrecruitment/">まとめインセンティブについて</a></li>
										<li><a href="http://sharetube.jp/authorrecruiting/">ライター募集</a></li>
										<li><a target="_blank" href="https://twitter.com/ShareTube_jp">Twitter</a></li>
										<li><a target="_blank" href="https://www.facebook.com/sharetube.jp/">Facebook</a></li>
										<li><a target="_blank" href="https://plus.google.com/+SharetubeJp0480">Google+</a></li>
									</ul>
								</dd>
							</dl>
						</li>
						<!-- アーカイブ -->
<!--
						<li class="li_clear">
							<dl>
								<dt>アーカイブ</dt>
								<dd>
									<ul>
										<li><a href="">2014年3月</a></li>
										<li><a href="">2014年2月</a></li>
										<li><a href="">2014年1月</a></li>
									</ul>
								</dd>
							</dl>
						</li>
-->
					</ol>
					<section class="drawer_nav_copy">
						<p>&copy; 2017 <a href="">Sharetube</a></p>
					</section>
				</nav>
			<!-- main -->
			<div class="main clearfix">
				<!-- sp_thumbnail -->
				
				<!-- navigation -->
				
					<!-- main_contents -->
				<div class="main_contents clearfix">
										</div>
				<!-- sidebar -->
				<div class="sidebar">
					
<div class="sidebar_ad">
<!--	<img src="assets/img/common/test_1.jpg" width="300" height="250" alt="" title=""> -->



	<?php // 広告配信
		// モバイル判別するPHPクラスライブラリを利用した機種判別
		$detect = Model_info_Basis::mobile_detect_create();
//		$ad_html = Model_Ad_Html::ad_html_create($detect, 'geniee','レクタングル');
		// Fluct広告
//		$ad_html = Model_Ad_Html::fluct_ad_html_create($detect, 'サイドバー右上', 'ミドル_3');

		// 全ての広告別array取得
		$all_ad_html_array = Model_Ad_Html::all_ad_html_array_get();
		// アドネットワークをランダムで取得
		$ad_network_name_sidebar_1 = Model_Ad_Basis::ad_network_random_get(array('fluct', 'geniee'));
		// 広告ネットワーク指定アドhtml生成
		$ad_sidebar_1_html   = Model_Ad_Html::all_ad_html_create($all_ad_html_array, $detect, 'fluct', $ad_network_name_sidebar_1, 'サイドバー右上', 'ミドル_3');
		echo ($ad_sidebar_1_html); ?>
</div>
<?php echo $sidebar_data["profile_card_html"]; ?>


<?php
		// モバイルからのアクセスなのかどうかを調べる
//		$user_is_mobil = Model_Info_Basis::mobil_is_access_check();
		// モバイル専用の広告を差し込む（モバイルでなかったら何も差し込まない）
//		$amoad_html = Model_Article_Html::mobil_article_amoad($user_is_mobil, 1, 15, 15);
//		var_dump($amoad_html);
		// モバイル判別するPHPクラスライブラリを利用した機種判別
		$detect = Model_info_Basis::mobile_detect_create();
		// Fluct広告
//		$ad_html = Model_Ad_Html::fluct_ad_html_create($detect, 'none', 'ミドル_4');
		// アドネットワークをランダムで取得
		$ad_network_name_sidebar_2 = Model_Ad_Basis::ad_network_random_get(array('fluct', 'geniee'));
		// 広告ネットワーク指定アドhtml生成
		$ad_sidebar_2_html   = Model_Ad_Html::all_ad_html_create($all_ad_html_array, $detect, 'fluct', $ad_network_name_sidebar_2, 'none', 'ミドル_4');
		echo '<div class="sidebar_ad" style="margin-top: 30px;">'.$ad_sidebar_2_html.'</div>';
?>
<?php echo $sidebar_data["popular_html"]; ?>
<?php echo $sidebar_data["related_html"]; ?>
<?php echo $sidebar_data["shuffle_html"]; ?>


<div class="sidebar_ad">

	<?php // 広告配信
		$detect = Model_info_Basis::mobile_detect_create();
//		$ad_html = Model_Ad_Html::ad_html_create($detect, 'geniee','レクタングル');
//		echo $ad_html;
		// Fluct広告
//		$ad_html = Model_Ad_Html::fluct_ad_html_create($detect, 'サイドバー右下', 'ミドル_5');
		// アドネットワークをランダムで取得
		$ad_network_name_sidebar_3 = Model_Ad_Basis::ad_network_random_get(array('fluct', 'geniee'));
		// 広告ネットワーク指定アドhtml生成
		$ad_sidebar_3_html   = Model_Ad_Html::all_ad_html_create($all_ad_html_array, $detect, 'fluct', $ad_network_name_sidebar_3, 'サイドバー右下', 'ミドル_5');
		echo ($ad_sidebar_3_html);
?>

</div>


<div class="sidebar_ad">

	<!-- キュレーター募集 -->
	<div class="curator_recruitment o_8 m_t_30">
		<a href="http://sharetube.jp/curatorrecruitment/lp/" target="blank">
			<img src="http://sharetube.jp/assets/img/curatorrecruitment/curator_recruitment_9.png" width="300" height="443">
		</a>
	</div>

	<!-- サイト情報 -->
	<div class="site_info_box clearfix">
		<ul>
			<li>© 2017 Sharetube</li>
			<li><a href="http://sharetube.jp/about/">Sharetubeについて</a></li>
			<li><a href="http://sharetube.jp/rule/rule">利用規約</a></li>
<!--
			<li><a href="http://sharetube.jp//">ヘルプ</a></li>
			<li><a href="http://sharetube.jp//">規約</a></li>
-->
			<li><a href="http://sharetube.jp/contact/">お問い合わせ</a></li>
			<li><a href="http://sharetube.jp/sitemap/">サイトマップ</a></li>
			<li><a href="http://sharetube.jp/signup/">まとめ作成</a></li>
			<li><a href="http://sharetube.jp/signup/">Sharetubeアカウント作成</a></li>
			<li><a href="http://sharetube.jp/login/" target="_blank">ログイン</a></li>
			<li><a href="http://sharetube.jp/curatorrecruitment/">まとめインセンティブについて</a></li>
			<li><a href="http://sharetube.jp/curatorrecruitment/lp/">業界NO.1のインセンティブ報酬</a></li>
			<li><a href="http://sharetube.jp/curatorlist/">キュレーターリスト</a></li>
			<li><a href="http://sharetube.jp/themelist/">テーマ一覧</a></li>
<!--
			<li><a href="http://sharetube.jp/permalink/recruitment_ads.php">広告掲載について</a></li>
-->
			<li><a href="http://sharetube.jp/assets/pdf/sharetube_document_7.pdf" target="_blank">広告掲載について</a></li>



<!--
			<li><a href="http://sharetube.jp//">採用情報</a></li>
-->
		</ul>
	</div>
</div>



<?php
/*
		// GameFeat広告
		$ad_html = Model_Ad_Html::GameFeat_ad_html_create($detect, 'none', 'ミドル_6');
	if($detect->isMobile() | $detect->isTablet()) {
		echo ('
			<div class="sidebar_ad">
				'.$ad_html.
			'</div>');
	}
*/
		// AdGeneration広告
//		$ad_html = Model_Ad_Html::AdGeneration_ad_html_create($detect, 'none', 'ミドル_7');
		// Fluct広告
//		$ad_7_html = Model_Ad_Html::fluct_ad_html_create($detect, 'none', 'ミドル_6');

		// アドネットワークをランダムで取得
		$ad_network_name_sidebar_4 = Model_Ad_Basis::ad_network_random_get(array('fluct', 'geniee'));
		// 広告ネットワーク指定アドhtml生成
		$ad_sidebar_4_html   = Model_Ad_Html::all_ad_html_create($all_ad_html_array, $detect, 'fluct', $ad_network_name_sidebar_4, 'none', 'ミドル_6');
		echo '<div class="sidebar_ad">
			'.$ad_sidebar_4_html.
		'</div>';
?>


				</div>
			</div>
			<!-- footer -->
				

















	<!-- シェアを促す機能 -->
	<div class="share_urge">
		<div class="share_urge_contents">
			<div class="share_urge_contents_left">
<!--
				<img width="179" height="47" title="シェアチューブ" alt="シェアチューブ" src="http://localhost/sharetube/assets/img/logo/logo_20.png">
-->
				<img width="80" height="115" title="シェアチューブ" alt="シェアチューブ" src="http://sharetube.jp/assets/img/character/character_2.png">
			</div> <!-- share_urge_contents_left -->
			<div class="share_urge_contents_right">
				<div class="share_urge_contents_header">
					この記事を共有しよう！
				</div>
				<div class="share_urge_contents_text">
					この記事は面白かったですか？ みんなで記事をシェアしましょう！
				</div>
							</div> <!-- share_urge_contents_right -->
		</div> <!-- share_urge_contents -->
	</div> <!-- share_urge -->
			
			<!-- footer -->
			<footer class="footer clear">
				<!-- footer_contents -->
				<div class="footer_contents clearfix">


					<!-- Page Plugin -->
<!--
					<div class="facebook_page_plugin">
						<div class="fb-page" data-href="https://www.facebook.com/sharetube.jp/" data-width="500" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"></div>
					</div>
-->


					<!-- like box -->
<!--
					<div class="face_book_plgin_shadow_hidden"> </div>
					<section class="face_book_plgin">
						<div class="fb-like-box" data-href="http://www.facebook.com/pages/Sharetube/621756284545794" data-width="768" data-height="243" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
						<div class="face_book_plgin_border_top"> </div>
						<div class="face_book_plgin_border_right"> </div>
						<div class="face_book_plgin_border_bottom"> </div>
						<div class="face_book_plgin_border_left"> </div>
					</section>
-->

					<!-- likeボタン -->
<!--
					<div class="fb-like" data-href="https://www.facebook.com/sharetube.jp/" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
-->


					<!--  -->
					<div class="footer_contents_box clearfix">
						<h5>Sharetubeについて</h5>
						<ul>
							<li><a href="http://sharetube.jp/about/">Sharetubeについて</a></li>
							<li><a href="http://sharetube.jp/rule/rule">利用規約</a></li>
							<li><a href="http://sharetube.jp/contact/">お問い合わせ</a></li>
<!--

							<li><a href="http://sharetube.jp/signup/">まとめ作成</a></li>
							<li><a href="http://sharetube.jp/signup/">Sharetubeアカウント作成</a></li>
							<li><a href="http://sharetube.jp/login/" target="_blank">ログイン</a></li>
							<li><a href="http://sharetube.jp/curatorlist/">キュレーターリスト</a></li>
							<li><a href="http://sharetube.jp/curatorrecruitment/">キュレーター募集</a></li>
							<li><a href="http://sharetube.jp/curatorrecruitment/lp/">業界NO.1のインセンティブ報酬</a></li>
-->



<!--
							<li><a href="http://sharetube.jp/permalink/recruitment_ads.php">広告掲載について</a></li>
-->


							<li><a href="http://sharetube.jp/assets/pdf/sharetube_document_7.pdf" target="_blank">広告掲載について</a></li>
<!--
							<li><a href="http://sharetube.jp/permalink/ch_thread_design_1.php">2ちゃんねるスレッドテキストベースまとめツール Var.1.00</a></li>
-->
						</ul>
					</div> <!--  -->


					<!--  -->
					<div class="footer_contents_box clearfix">
						<h5>新着・過去まとめについて</h5>
						<ul>
					  	<li><a href="http://sharetube.jp/newarticle/">新着まとめ</a></li>
					  	<li><a href="http://sharetube.jp/archive/">アーカイブ</a></li>
						</ul>
						<ul>
<!--
							<li>2014年05月</li>
							<li>2014年04月</li>
							<li>2014年03月</li>
							<li>2014年02月</li>
							<li>2014年01月</li>
-->
						
						</ul>
					</div> <!--  -->
					<!--  -->
					<div class="footer_contents_box clearfix">
						<h5>Sharetubeをフォローする</h5>
						<ul>
					  	<li><a href="https://www.facebook.com/sharetube.jp/" target="_blank">Facebook</a></li>
					  	<li><a href="https://twitter.com/Sharetube_jp" target="_blank">Twitter</a></li>
					  	<li><a href="https://plus.google.com/+SharetubeJp0480" target="_blank">Google+</a></li>
					  	<li><a href="http://localhost/sharetube/feed.xml">RSS配信</a></li>
					  	<li><a target="blank" href="http://cloud.feedly.com/#subscription%2Ffeed%2Fhttp%3A%2F%2Fsharetube.jp%2Ffeed.xml">Feedlyで購読</a></li>
						</ul>
					</div> <!--  -->


				</div> <!-- footer_contents -->
				<!-- footer_bottom -->
				<div class="footer_bottom">
					<div class="footer_bottom_contents">
						<!-- コピーライト -->
						<section id="copy">
							<p class="m_0">&copy; 2017 <a href="">Sharetube</a></p>
						</section>
						<!--  -->
						<div class="footer_bottom_contents_outer">
								<div class="footer_bottom_contents_logo"></div>
						</div>
					</div>
				</div>
			</footer>  <!-- footer -->
			
			<!-- jQueryプラグイン -->
			<script type="text/javascript" src="http://sharetube.jp/assets/js/common/jquery-1.9.1-min.js"></script>
			<!-- 自作プラグイン -->
			<script type="text/javascript" src="http://sharetube.jp/assets/js/common/common.js"></script>
			<!-- シェアを促すプラグイン -->
			<script type="text/javascript" src="http://sharetube.jp/assets/js/article/share_urge.js"></script>
			<!-- Twitterscrapingプラグイン -->
			<script type="text/javascript" src="http://sharetube.jp/assets/js/twitterscraping/common.js"></script>
			<!-- Twitter_image_viewプラグイン -->
			<script type="text/javascript" src="http://sharetube.jp/assets/js/article/twitter_image_view.js"></script>
			<!-- sweetalert-devプラグイン -->
			<script type="text/javascript" src="http://sharetube.jp/assets/library/sweetalert-master/dist/sweetalert-dev.js"></script>

			<!-- 記事のサムネを背景に表示するプラグイン -->
<!--
			<script type="text/javascript" src="http://sharetube.jp/assets/js/article/background_thumbnail_view.js"></script>
-->

		<!-- flickity プラグイン -->
		<script src="http://sharetube.jp/assets/js/library/flickity.1.1.1/flickity.pkgd.min.js"></script>

		<!-- ピックアップ -->
		<script>
		$('.matome_content_block_itunes_app_data_screenshots').css( {
			'height' :'auto',
			'overflow': 'auto'
		});
		$('.matome_content_block_itunes_app_data_screenshots').flickity({
			freeScroll: true,
			contain: true,
			prevNextButtons: false,
			pageDots: false,
			lazyLoad: true,
		});
		</script>






			<!-- FBページプラグイン -->
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.4";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

			<!-- Twitterプラグイン -->
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			<!-- はてなプラグイン -->
			<script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
			<!-- Pocketプラグイン -->
			<script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>
			<!-- グーグル+プラグイン -->
			<!-- head 内か、body 終了タグの直前に次のタグを貼り付けてください。 -->
			<script src="https://apis.google.com/js/platform.js" async defer>
			  {lang: 'ja'}
			</script>
				</div>
	</body>
</html>

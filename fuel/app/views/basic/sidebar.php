
<div class="sidebar_ad">
<!--	<img src="<?php echo Uri::base(); ?>assets/img/common/test_1.jpg" width="300" height="250" alt="" title=""> -->
	<?php // 広告配信
		// モバイル判別するPHPクラスライブラリを利用した機種判別
		$detect = Model_info_Basis::mobile_detect_create();
//		$ad_html = Model_Ad_Html::ad_html_create($detect, 'geniee','レクタングル');
		// Fluct広告
//		$ad_html = Model_Ad_Html::fluct_ad_html_create($detect, 'サイドバー右上', 'ミドル_3');

		// 全ての広告別array取得
		$all_ad_html_array = Model_Ad_Html::all_ad_html_array_get();
		// アドネットワークをランダムで取得
		$ad_pc_network_name_sidebar_1     = Model_Ad_Basis::ad_network_random_get(array('fluct', 'geniee'));
		$ad_mobile_network_name_sidebar_1 = Model_Ad_Basis::ad_network_random_get(array('fluct', 'geniee', 'geniee', 'geniee'));
		// 広告ネットワーク指定アドhtml生成
		$ad_sidebar_1_html   = Model_Ad_Html::all_ad_html_create($all_ad_html_array, $detect, $ad_pc_network_name_sidebar_1, $ad_mobile_network_name_sidebar_1, 'サイドバー右上', 'ミドル_3');
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
		$ad_network_name_sidebar_2 = Model_Ad_Basis::ad_network_random_get(array('fluct', 'geniee', 'geniee', 'geniee'));
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
		$ad_pc_network_name_sidebar_3     = Model_Ad_Basis::ad_network_random_get(array('fluct', 'geniee'));
		$ad_mobile_network_name_sidebar_3 = Model_Ad_Basis::ad_network_random_get(array('fluct', 'geniee', 'geniee', 'geniee'));
		// 広告ネットワーク指定アドhtml生成
		$ad_sidebar_3_html   = Model_Ad_Html::all_ad_html_create($all_ad_html_array, $detect, $ad_pc_network_name_sidebar_3, $ad_mobile_network_name_sidebar_3, 'サイドバー右下', 'ミドル_5');
		echo ($ad_sidebar_3_html);
?>
</div>

<?php
		// GameFeat広告
//		$ad_html = Model_Ad_Html::GameFeat_ad_html_create($detect, 'none', 'ミドル_7');
/*
	if($detect->isMobile() | $detect->isTablet()) {
		echo ('
			<div class="sidebar_ad">
				<div class="article_inside_related_article_header">
					<span>ランキングゲームまとめ</span>
					<span class="article_inside_related_article_header_line"> </span>
				</div>'.$ad_html.
			'</div>');
	}
*/
?>

<div class="sidebar_ad">

	<!-- キュレーター募集 -->
	<div class="curator_recruitment o_8 m_t_30">
		<a href="<?php echo HTTP; ?>curatorrecruitment/lp/" target="blank">
			<img src="<?php echo HTTP; ?>assets/img/curatorrecruitment/curator_recruitment_9.png" width="300" height="443">
		</a>
	</div>

	<!-- サイト情報 -->
	<div class="site_info_box clearfix">
		<ul>
			<li>© <?php echo date('Y'); ?> Sharetube</li>
			<li><a href="<?php echo HTTP; ?>about/">Sharetubeについて</a></li>
			<li><a href="<?php echo HTTP; ?>rule/rule">利用規約</a></li>
<!--
			<li><a href="<?php echo HTTP; ?>/">ヘルプ</a></li>
			<li><a href="<?php echo HTTP; ?>/">規約</a></li>
-->
			<li><a href="<?php echo HTTP; ?>contact/">お問い合わせ</a></li>
			<li><a href="<?php echo HTTP; ?>sitemap/">サイトマップ</a></li>
			<li><a href="<?php echo HTTP; ?>signup/">まとめ作成</a></li>
			<li><a href="<?php echo HTTP; ?>signup/">Sharetubeアカウント作成</a></li>
			<li><a href="<?php echo HTTP; ?>login/" target="_blank">ログイン</a></li>
			<li><a href="<?php echo HTTP; ?>curatorrecruitment/">まとめインセンティブについて</a></li>
			<li><a href="<?php echo HTTP; ?>curatorrecruitment/lp/">業界NO.1のインセンティブ報酬</a></li>
			<li><a href="<?php echo HTTP; ?>curatorlist/">キュレーターリスト</a></li>
			<li><a href="<?php echo HTTP; ?>themelist/">テーマ一覧</a></li>
<!--
			<li><a href="<?php echo HTTP; ?>permalink/recruitment_ads.php">広告掲載について</a></li>
-->
			<li><a href="<?php echo HTTP; ?>assets/pdf/sharetube_document_7.pdf" target="_blank">広告掲載について</a></li>



<!--
			<li><a href="<?php echo HTTP; ?>/">採用情報</a></li>
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
		$ad_network_name_sidebar_4 = Model_Ad_Basis::ad_network_random_get(array('fluct', 'geniee', 'geniee', 'geniee'));
		// 広告ネットワーク指定アドhtml生成
		$ad_sidebar_4_html   = Model_Ad_Html::all_ad_html_create($all_ad_html_array, $detect, 'fluct', $ad_network_name_sidebar_4, 'none', 'ミドル_6');
		echo '<div class="sidebar_ad">
			'.$ad_sidebar_4_html.
		'</div>';
?>




<div class="sidebar_ad">
<!--	<img src="<?php echo Uri::base(); ?>assets/img/common/test_1.jpg" width="300" height="250" alt="" title=""> -->
	<?php // 広告配信
		// モバイル判別するPHPクラスライブラリを利用した機種判別
		$detect = Model_info_Basis::mobile_detect_create();
//		$ad_html = Model_Ad_Html::ad_html_create($detect, 'geniee','レクタングル');
		// Fluct広告
		$ad_html = Model_Ad_Html::fluct_ad_html_create($detect, 'サイドバー右上', 'ミドル_3');
		echo ($ad_html); ?>
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
		$ad_html = Model_Ad_Html::fluct_ad_html_create($detect, 'none', 'ミドル_4');
		echo '<div class="sidebar_ad" style="margin-top: 30px;">'.$ad_html.'</div>';
?>




<?php echo $sidebar_data["popular_html"]; ?>
<?php echo $sidebar_data["related_html"]; ?>
<?php echo $sidebar_data["shuffle_html"]; ?>

<!--

<nav class="shuffle_article">
	<div class="shuffle_article_content">
		<div class="shuffle_article_header">
			<span>Sharetubeをフォローする</span>
			<span class="shuffle_article_header_line"> </span>
		</div>
			<div class="fb-like-box m_b_15" data-href="https://www.facebook.com/pages/Sharetube/621756284545794" data-colorscheme="light" data-show-faces="false" data-header="true" data-stream="false" data-show-border="true"></div>

			<a href="https://twitter.com/Sharetube_jp" class="twitter-follow-button" data-show-count="false" data-lang="ja" data-size="large">@Sharetube_jpさんをフォロー</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

			<div class="sidebar_ad m_t_15">
				<div class="g-page" data-href="//plus.google.com/u/0/107381623798713481989" data-rel="publisher"></div>
			</div>
	</div>
</nav>
-->








<div class="sidebar_ad">



	<?php // 広告配信
		$detect = Model_info_Basis::mobile_detect_create();
//		$ad_html = Model_Ad_Html::ad_html_create($detect, 'geniee','レクタングル');
//		echo $ad_html;
		// Fluct広告
		$ad_html = Model_Ad_Html::fluct_ad_html_create($detect, 'サイドバー右下', 'ミドル_5');
		echo ($ad_html);
?>
</div>





<?php
		// GameFeat広告
		$ad_html = Model_Ad_Html::GameFeat_ad_html_create($detect, 'none', 'ミドル_7');
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
			<img src="<?php echo HTTP; ?>assets/img/curatorrecruitment/curator_recruitment_8.png" width="300" height="443">
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
			<li><a href="<?php echo HTTP; ?>permalink/recruitment_ads.php">広告掲載について</a></li>
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
		$ad_7_html = Model_Ad_Html::fluct_ad_html_create($detect, 'none', 'ミドル_6');

	if($detect->isMobile() | $detect->isTablet()) {
		echo ('
			<div class="sidebar_ad">
				'.$ad_7_html.
			'</div>');
	}
?>


















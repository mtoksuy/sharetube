	<?php //echo $plus_add_data["share_urge_html"]; ?>

<?php
/*
	<!-- 追跡型シェアボタンリスト -->
	<div class="tracking_social_button_list">
			<ul>
				<li class="facebook_button">
					<!-- facebookボタン -->
					<div class="fb-share-button" data-href="'.HTTP.''.$article_type.'/'.$value["link"].'/" data-type="button"></div>
				</li>
				<li class="twitter_button">
					<!-- twitterボタン -->
					<a href="https://twitter.com/share" class="twitter-share-button" data-via="Sharetube_jp" data-lang="ja" data-count="none">ツイート</a>
				</li>
				<li class="hatena_button">
					<!-- はてなボタン -->
					<a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="standard-noballoon" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a>
				</li>
				<li class="pocket_button">
					<!-- ポケットボタン -->
					<a data-pocket-label="pocket" data-pocket-count="none" class="pocket-btn" data-lang="en"></a>
				</li>
				<li class="google_plus_button">
					<!-- google+ボタン -->
					<!-- +1 ボタン を表示したい位置に次のタグを貼り付けてください。 -->
					<div class="g-plusone" data-size="tall" data-annotation="none"></div>
				</li>
			</ul>
	</div>
*/
?>


<?php
/*
	<!-- 追跡型シェアボタンリスト -->
	<div class="tracking_social_button_list">
		<div class="tracking_social_button_list_left">
			<div class="tracking_social_button_list_title">シェアをしよう！</div>
			<div class="tracking_social_button_list_facebook_like_button">
				<div class="fb-like" data-href="https://www.facebook.com/pages/Sharetube/621756284545794" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
			</div>
		</div>
		<?php echo $plus_add_data["social_share_html"]; ?>
	</div>
*/
?>















	<!-- シェアを促す機能 -->
	<div class="share_urge">
		<div class="share_urge_contents">
			<div class="share_urge_contents_left">
<!--
				<img width="179" height="47" title="シェアチューブ" alt="シェアチューブ" src="http://localhost/sharetube/assets/img/logo/logo_20.png">
-->
				<img width="80" height="115" title="シェアチューブ" alt="シェアチューブ" src="<?php echo HTTP; ?>assets/img/character/character_2.png">
			</div> <!-- share_urge_contents_left -->
			<div class="share_urge_contents_right">
				<div class="share_urge_contents_header">
					この記事を共有しよう！
				</div>
				<div class="share_urge_contents_text">
					この記事は面白かったですか？ みんなで記事をシェアしましょう！
				</div>
				<?php echo $plus_add_data["social_share_html"]; ?>
			</div> <!-- share_urge_contents_right -->
		</div> <!-- share_urge_contents -->
	</div> <!-- share_urge -->

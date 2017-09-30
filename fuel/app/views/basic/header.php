




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
			<?php echo $content_data['all_header_ad_html']; ?>
		<!-- header -->
		<header id="header" class="clearfix">
			<div class="header_contents clearfix">
				<!-- logo -->
				<div class="logo">
					<h1>
						<a class="o_8" href="<?php echo HTTP; ?>"><img src="<?php echo HTTP; ?>assets/img/logo/logo_29.png" width="135" height="36" alt="シェアチューブ" title="シェアチューブ"></a>
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
							<span><a href="<?php echo HTTP; ?>about/">アバウト</a></span>
						</li>
-->
						<li class="navi_items">
							<span class="trigger_category">カテゴリ</span>
							<!-- category_nav -->
							<div class="category_nav">
								<ul class="">
									<li><a href="<?php echo HTTP; ?>entertainment_culture/">エンタメ・カルチャー</a></li>
									<li><a href="<?php echo HTTP; ?>news_gossip/">ニュース・ゴシップ</a></li>
									<li><a href="<?php echo HTTP; ?>cute/">かわいい</a></li>
									<li><a href="<?php echo HTTP; ?>girls/">ガールズ</a></li>
									<li><a href="<?php echo HTTP; ?>life_idea/">暮らし・アイデア</a></li>
									<li><a href="<?php echo HTTP; ?>body/">カラダ</a></li>
									<li><a href="<?php echo HTTP; ?>spot_gourmet/">おでかけ・グルメ</a></li>
									<li><a href="<?php echo HTTP; ?>recipe/">レシピ</a></li>
								</ul>
								<ul class="" style="width: 241px;">
									<li><a href="<?php echo HTTP; ?>humor/">おもしろ</a></li>
									<li><a href="<?php echo HTTP; ?>anime_game/">アニメ・ゲーム</a></li>
									<li><a href="<?php echo HTTP; ?>app_gadget/">アプリ・ガジェット</a></li>
									<li><a href="<?php echo HTTP; ?>design_art/">デザイン・アート</a></li>
									<li><a href="<?php echo HTTP; ?>developer_programming/">開発・プログラミング</a></li>
									<li><a href="<?php echo HTTP; ?>innovation_technology/">イノベーション・テクノロジー</a></li>
									<li><a href="<?php echo HTTP; ?>business_startup/">ビジネス・スタートアップ</a></li>
									<li><a href="<?php echo HTTP; ?>notice/">お知らせ</a></li>
								</ul>
							</div>
						</li>
						<li class="navi_items">
							<span><a href="<?php echo HTTP; ?>signup/">アカウント作成</a></span>
						</li>
						<li class="navi_items">
							<span><a href="<?php echo HTTP; ?>login/">ログイン</a></span>
						</li>
						<li class="navi_items">
							<span><a target="blank" href="<?php echo HTTP; ?>contact/">お問い合わせ</a></span>
						</li>
						<li class="navi_items">
							<div class="fb-like" data-href="https://www.facebook.com/sharetube.jp/" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
						</li>
					</ul>
				</div>
				<!-- nav -->
				<nav class="nav">
					<ul class="clearfix">
						<li><a><img src="<?php echo HTTP; ?>assets/img/common/navi_icon_4.png" width="30" height="19" alt="about_icon"></a></li>
					</ul>
				</nav>
				<!-- search_window -->
				<nav class="search_window">
					<form method="post" action="<?php echo HTTP; ?>search/" class="search_window_form">
						<input type="text" placeholder="気になったキーワードを検索" value="<?php if($_POST["search"]) { echo $_POST["search"];} ?>" name="search" id="search">
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
				  	<li><a target="_blank" href="https://www.facebook.com/sharetube.jp/"><img width="30" height="30" src="<?php echo HTTP; ?>assets/img/common/new_facebook_icon_1.png" alt="" title="Facebook"></a></li>
				  	<li><a target="_blank" href="https://twitter.com/Sharetube_jp"><img width="30" height="30" src="<?php echo HTTP; ?>assets/img/common/new_twitter_icon_1.png" alt="" title="Twitter"></a></li>
				  	<li><a target="_blank" href="https://plus.google.com/+SharetubeJp0480"><img width="30" height="30" src="<?php echo HTTP; ?>assets/img/common/google+_icon_2.png" alt="" title="Google+"></a></li>
				  	<li><a href="<?php echo HTTP; ?>feed.xml"><img width="30" height="30" src="<?php echo HTTP; ?>assets/img/common/new_rss_icon_1.png" alt="" title="RSS"></a></li>
				  	<li><a href='http://cloud.feedly.com/#subscription%2Ffeed%2Fhttp%3A%2F%2Fsharetube.jp%2Ffeed.xml'  target='blank'><img id='feedlyFollow' src='http://s3.feedly.com/img/follows/feedly-follow-rectangle-flat-medium_2x.png' alt='follow us in feedly' width='71' height='28'></a></li>
				  </ul>
				</div>
			</section>
			<!-- スクロールトップ -->
			<div class="scroll_top o_8">
				<img width="48" height="48" alt="scroll_icon" title="一番上に移動" src="<?php echo HTTP; ?>assets/img/common/scroll_top_7.png">
			</div>
			<!-- シャッフルボタン -->
			<div class="shuffle_button o_8">
				<a href="<?php echo $header_data["shuffle_article_url"]; ?>">
				<img width="52" height="48" alt="shuffle_button" title="ページをシャッフル" src="<?php echo HTTP; ?>assets/img/common/shuffle_button_4.png">
				</a>
			</div>
			<?php
				if(preg_match('/article/',$_SERVER['REQUEST_URI']) | $header_data['article_id']) {
					$contents_check = false;
					$article_id = (int)preg_replace('/[^0-9]/', '', $header_data['article_id']);
					$res = DB::query("
						SELECT sub_text
						FROM article
						WHERE primary_id = ".$article_id."
						AND del = 0
						AND sub_text LIKE '%matome_content_block_contents%'
					")->cached(3600)->execute();
					foreach($res as $key => $value) {
						$contents_check = true;
					}
					if($contents_check) {?>
					<!-- 目次へ移動ボタン -->
					<div class="contents_button o_8">
						<img width="52" height="48" alt="contents_button" title="目次へ移動" src="<?php echo HTTP; ?>assets/img/common/scroll_index_2.png">
					</div>
					<?php 
					}
				} ?>

				<!-- drawer_nav -->
				<nav class="drawer_nav clearfix">
					<ol>
						<!-- 検索 -->
						<li class="li_clear">
							<dl>
								<dt></dt>
								<dd>
									<form method="post" action="<?php echo HTTP; ?>search/" class="search_form">
										<input type="text" placeholder="検索" value="<?php if($_POST["search"]) { echo $_POST["search"];} ?>" name="search" id="search">
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
										<li><a href="<?php echo HTTP; ?>vine/">Sharetube@Vine</a></li>
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
										<li><a href="<?php echo HTTP; ?>entertainment_culture/">エンタメ・カルチャー</a></li>
										<li><a href="<?php echo HTTP; ?>news_gossip/">ニュース・ゴシップ</a></li>
										<li><a href="<?php echo HTTP; ?>cute/">かわいい</a></li>
										<li><a href="<?php echo HTTP; ?>girls/">ガールズ</a></li>
										<li><a href="<?php echo HTTP; ?>life_idea/">暮らし・アイデア</a></li>
										<li><a href="<?php echo HTTP; ?>body/">カラダ</a></li>
										<li><a href="<?php echo HTTP; ?>spot_gourmet/">おでかけ・グルメ</a></li>
										<li><a href="<?php echo HTTP; ?>recipe/">レシピ</a></li>
										<li><a href="<?php echo HTTP; ?>humor/">おもしろ</a></li>
										<li><a href="<?php echo HTTP; ?>anime_game/">アニメ・ゲーム</a></li>
										<li><a href="<?php echo HTTP; ?>app_gadget/">アプリ・ガジェット</a></li>
										<li><a href="<?php echo HTTP; ?>design_art/">デザイン・アート</a></li>
										<li><a href="<?php echo HTTP; ?>developer_programming/">開発・プログラミング</a></li>
										<li><a href="<?php echo HTTP; ?>innovation_technology/">イノベーション・テクノロジー</a></li>
										<li><a href="<?php echo HTTP; ?>business_startup/">ビジネス・スタートアップ</a></li>
										<li><a href="<?php echo HTTP; ?>notice/">お知らせ</a></li>
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
										<li><a href="<?php echo HTTP; ?>about/">Sharetubeについて</a></li>
										<li><a href="<?php echo HTTP; ?>rule/rule">利用規約</a></li>
										<li><a href="<?php echo HTTP; ?>contact/">お問い合わせ</a></li>
										<li><a href="<?php echo HTTP; ?>sitemap/">サイトマップ</a></li>
										<li><a href="<?php echo HTTP; ?>permalink/recruitment_ads.php">広告掲載について</a></li>
										<li><a href="<?php echo HTTP; ?>signup/">まとめ作成</a></li>
										<li><a href="<?php echo HTTP; ?>signup/">Sharetubeアカウント作成</a></li>
										<li><a href="<?php echo HTTP; ?>login/" target="_blank">ログイン</a></li>
										<li><a href="<?php echo HTTP; ?>curatorrecruitment/">キュレーター募集</a></li>
										<li><a href="<?php echo HTTP; ?>curatorrecruitment/">まとめインセンティブについて</a></li>
										<li><a href="<?php echo HTTP; ?>authorrecruiting/">ライター募集</a></li>
										<li><a target="_blank" href="https://twitter.com/ShareTube_jp">Twitter</a></li>
										<li><a target="_blank" href="https://www.facebook.com/pages/Sharetube/621756284545794">Facebook</a></li>
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
						<p>&copy; <?php echo date('Y'); ?> <a href="">Sharetube</a></p>
					</section>
				</nav>

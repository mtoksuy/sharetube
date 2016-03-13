<!DOCTYPE html>
<html>
	<head>
		<title>業界NO.1のインセンティブ報酬を支払うSharetubeでまとめを作成してみませんか？</title>
		<!-- meta -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
		<meta name="keywords" content="キュレーター, 稼ぐ, お小遣い, 在宅, SOHO, 仕事, ワークス, まとめ" />
		<meta property="og:title" content="業界NO.1のインセンティブ報酬を支払うSharetubeでまとめを作成してみませんか？ " />
		<meta property="og:type" content="website" />
		<!-- icon -->
		<link rel="shortcut icon" href="<?php echo HTTP; ?>assets/img/icon/favicon_4.ico" type="image/vnd.microsoft.icon">
		<!-- rss -->
		<link rel="alternate" type="application/rss+xml" title="Sharetube RSSフィード" href="<?php echo HTTP; ?>feed.xml">
		<!-- css -->
		<link rel="stylesheet" href="<?php echo HTTP; ?>assets/css/common/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo HTTP; ?>assets/css/matome/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo HTTP; ?>assets/css/library/typicons.2.0.7/font/typicons.css" type="text/css">
		<link rel="stylesheet" href="<?php echo HTTP; ?>assets/css/library/flickity.1.1.1/flickity.css" type="text/css" media="screen">
		<link rel="apple-touch-icon" href="<?php echo HTTP; ?>assets/img/icon/apple_touch_icon_1.png" />
		<link rel="apple-touch-icon-precomposed" href="<?php echo HTTP; ?>assets/img/icon/apple_touch_icon_1.png" />
		<link rel="stylesheet" href="<?php echo HTTP; ?>assets/css/article/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo HTTP; ?>assets/css/signup/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo HTTP; ?>assets/css/permalink/curatorrecruitment/lp/common.css" type="text/css">
	</head>
	<body>
		<!-- wrapper -->
		<div id="wrapper">
			<!-- top_header -->
			<div class="top_header clearfix">
				<div class="top_header_contents"></div>
			</div>
			<!-- header -->
			<header id="header" class="clearfix">
				<div class="header_contents clearfix">
					<!-- logo -->
					<div class="logo">
						<h1>
							<a class="o_8" href="<?php echo HTTP; ?>">
								<img src="<?php echo HTTP; ?>assets/img/logo/logo_27.png" width="155" height="59" alt="シェアチューブ" title="シェアチューブ">
							</a>
						</h1>
					</div>
				</div>
			</header>
			<!-- main -->
			<div class="main clearfix">
				<!-- main_contents -->
				<div class="main_contents clearfix">
					<!-- first_view_block -->
					<div class="first_view_block clearfix">
						<div class="first_view_block_content clearfix">
							<h1>在宅で隙間時間を利用して報酬を得られる。
								<br>
								<span class="bottom_line">業界NO.1のインセンティブ報酬</span>を支払うSharetubeでまとめを作成してみませんか？
							</h1>
							<div class="block clearfix">
								<div class="left_block">
									<ol>
										<li>
											<dl>
												<dt><img src="<?php echo HTTP; ?>assets/img/curatorrecruitment/lp/check_1.svg" width="18" height="18" style="margin: 0 7px 5px -20px;">完全無料</dt>
												<dd>Sharetubeが提供するツールを自由に無料でご利用できます。</dd>
											</dl>
										</li>
										<li>
											<dl>
												<dt><img src="<?php echo HTTP; ?>assets/img/curatorrecruitment/lp/check_1.svg" width="18" height="18">未経験者OK</dt>
												<dd>誰でもいつでも簡単にまとめを作成できます。</dd>
											</dl>
										</li>
										<li>
											<dl>
												<dt><img src="<?php echo HTTP; ?>assets/img/curatorrecruitment/lp/check_1.svg" width="18" height="18">自由換金OK</dt>
												<dd>貯めたPVを自由に換金することができます。</dd>
											</dl>
										</li>
									</ol>
								</div>
								<div class="signup clearfix">
									<p>メンバー登録は無料！ぜひ、あなたのまとめをみんなに共有してみてください。 </p>
									<div class="signup_content clearfix">
										<h2>
											<strong>Sharetubeで情報をまとめてみませんか?</strong>
										</h2>

<?php 
	// ポスト取得
	$post = Library_Security_Basis::post_security();
	if($post) {
		// sharetube_idチェック
		$user_sharetube_id_check = Model_Signup_Basis::sharetube_id_check($post);
		// メールアドレスチェック
		$user_email_check        = Model_Signup_Basis::email_check($post);
		// パスワードをチェック
		$user_password_check     = Model_Signup_Basis::password_check($post);
		// 全てがtrueの場合
		if($user_sharetube_id_check && $user_email_check && $user_password_check) {
			// ユーザー登録
			Model_Signup_Basis::user_signup($post);
			// lpからの登録されたことをわかるためにDBに登録する
			Model_Lp_Basis::user_lp_signup_db_insert($post, 'top');
			header('location:'.HTTP.'curatorrecruitment/lp/complete/');
			exit;
		}
		if(!$user_sharetube_id_check) {
			$sharetube_id_caution_text = '<p class="red">既に登録されているidか登録できない文字列が含まれています</p>';
		}
		if(!$user_email_check) {
			$email_caution_text = '<p class="red">既に登録されているかメールアドレスが間違っています</p>';
		}
		if(!$user_password_check) {
			$password_caution_text = '<p class="red">4文字以下か使用できない文字列が含まれています</p>';
		}
	}
	?>
										<!-- フォーム -->
										<form method="post" id="signup_form" class="signup_form" action="">
											<div class="field">
												<input type="text" placeholder="Sharetube ID(半角英数字)" value="<?php echo $post['sharetube_id'] ;?>" maxlength="20" name="sharetube_id" autocomplete="off">
											</div>
											<?php echo $sharetube_id_caution_text; ?>

											<div class="field">
												<input type="email" placeholder="メールアドレスを入力" value="<?php echo $post['email'] ;?>" name="email" autocomplete="off">
											</div>
											<?php echo $email_caution_text; ?>
											<div class="field">
												<input type="password" placeholder="パスワード(半角英数字のみ4文字以上)" name="password">
											</div>
											<?php echo $password_caution_text; ?>

											<button class="signup_form_button o_8" type="submit">Sharetubeに登録する</button>
										</form> <!-- フォーム -->
									</div>
								</div>
							</div>
							<div class="registration_button o_8 clearfix">
								<a href="<?php echo HTTP; ?>curatorrecruitment/lp/signup/" target="_blank">今すぐ無料登録してまとめを書く</a>
							</div>
						</div>
					</div> <!-- first_view_block -->
					<!-- appeal_block -->
					<div class="appeal_block">
						<h2>Share<span class="red">tube</span>とは？
						</h2>
						<p>Sharetubeは伝えたい情報を自由に組み合わせ、世界でたった一つのオリジナルページを作成・紹介できるキュレーションプラットフォームサービス。業界NO.1の報酬を得ながらまとめを作成できるWebサービスです。</p>
						<div class="clearfix">
							<img class="appeal_block_image_3" width="640" height="400" src="<?php echo HTTP; ?>assets/img/curatorrecruitment/lp/iphone_5_mockup_sharetube_1.png">
							<img class="appeal_block_image_4" width="640" height="400" src="<?php echo HTTP; ?>assets/img/curatorrecruitment/lp/macbook_pro_mockup_sharetube_1.png">
						</div>
					</div> <!-- first_view_block -->
					<!-- appeal_block -->
					<div class="appeal_block">
						<h2>PVに応じて<span class="red">報酬</span>がもらえる</h2>
						<p>業界NO.1の報酬レートを設定しているSharetube。報酬が今すぐ欲しい場合も1クリックで簡単に申請して、かつ2～3営業日以内に振り込まれるのも魅力的なところ。</p><p>もちろん作成したまとめは消さない限り、永久にインセンティブを発生させるので長期的にお金がもらえます。</p>




						<img class="appeal_block_image_1" width="640" height="400" src="<?php echo HTTP; ?>assets/img/article/image/image_4972.png">
						<div class="appeal_float_block clearfix">
							<div class="appeal_float_block_left">
								<img class="appeal_block_image_2" width="640" height="400" title="" alt="" src="<?php echo HTTP; ?>assets/img/article/image/image_3779.png" class="o_8">
							</div>
							<div class="appeal_float_block_right">
								<h3>マツオカソウヤさんの場合</h3>
								<img class="appeal_block_image_2" width="640" height="400" title="" alt="" src="<?php echo HTTP; ?>assets/img/curatorrecruitment/lp/ss_2.jpg" class="o_8">
							</div>
						</div>
					</div>
					<!-- appeal_block -->
					<div class="appeal_block">
						<h2><span class="red">認知度アップ</span>にも繋がる</h2>
						<p>しっかりとしたユーザーページ とアイコン・自己紹介文・運営サイト・SNSリンクを設定できて、作成したまとめにもプロフィールが載るので認知度アップにも繋がります。</p>
						<img class="appeal_block_image_2" width="640" height="400" title="" alt="" src="<?php echo HTTP; ?>assets/img/curatorrecruitment/lp/channel_view_1.jpg" class="o_8">
					</div>
					<!-- appeal_block -->
					<div class="appeal_block">
						<h2><span class="red">自由</span>にまとめを作成できる</h2>
						<p class="appeal_p_4">誰にでも自由なまとめを作成できる環境を用意しています。テーマの指定も一切なく時間にも場所にも縛られずにインセンティブ報酬がもらえます。</p>
					</div>

					<div class="registration_button o_8 clearfix">
						<a href="<?php echo HTTP; ?>curatorrecruitment/lp/signup/" target="_blank">今すぐ無料登録してまとめを書く</a>
					</div>
				</div>
			</div>
			<!-- footer -->
			<footer class="footer clear">
				<!-- footer_contents -->
				<div class="footer_contents clearfix">
					<div class="footer_contents_box clearfix">
						<h5>Sharetubeについて</h5>
						<ul>
							<li>ボックス</li>
							<li><a href="<?php echo HTTP; ?>about/">Sharetubeについて</a></li>
							<li><a href="<?php echo HTTP; ?>contact/">お問い合わせ</a></li>
							<li><a href="<?php echo HTTP; ?>sitemap/">サイトマップ</a></li>
							<li><a href="<?php echo HTTP; ?>permalink/recruitment_ads.php">広告掲載について</a></li>
							<li><a href="<?php echo HTTP; ?>signup/">まとめ作成</a></li>
							<li><a href="<?php echo HTTP; ?>signup/">Sharetubeアカウント作成</a></li>
							<li><a target="_blank" href="<?php echo HTTP; ?>login/">ログイン</a></li>
							<li><a href="<?php echo HTTP; ?>curatorrecruitment/">キュレーター募集</a></li>
							<li><a href="<?php echo HTTP; ?>curatorrecruitment/">まとめインセンティブについて</a></li>
							<li><a href="<?php echo HTTP; ?>authorrecruiting/">ライター募集</a></li>
							<li><a href="<?php echo HTTP; ?>permalink/ch_thread_design_1.php">2ちゃんねるスレッドテキストベースまとめツール Var.1.00</a></li>
						</ul>
					</div>
				</div>
				<div class="footer_bottom">
					<div class="footer_bottom_contents">
						<!-- コピーライト -->
						<section id="copy">
							<p class="m_0">&copy; 2016 <a href="<?php echo HTTP; ?>">Sharetube</a></p>
						</section>
						<!--  -->
						<div class="footer_bottom_contents_outer">
								<div class="footer_bottom_contents_logo"></div>
						</div>
					</div>
				</div>
			</footer>
		</div>
		<!-- jQueryプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/jquery-1.9.1-min.js"></script>
		<!-- 自作プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/common.js"></script>
	</body>
</html>
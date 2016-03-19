<!DOCTYPE html>
<html>
	<head>
		<title>サインアップ | 業界NO.1のインセンティブ報酬を支払うSharetubeでまとめを作成してみませんか？</title>
		<!-- meta -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
		<meta name="keywords" content="キュレーター, 稼ぐ, お小遣い, 在宅, SOHO, 仕事, ワークス, まとめ" />
		<meta property="og:title" content="サインアップ | 業界NO.1のインセンティブ報酬を支払うSharetubeでまとめを作成してみませんか？" />
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
							<h1></h1>
							<div class="block clearfix">
								<div class="signup clearfix" style="float: none; margin: 0px auto;">
									<div class="signup_content clearfix">
										<h2>
											<strong>今すぐ無料登録してまとめを書く</strong>
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
			Model_Lp_Basis::user_lp_signup_db_insert($post, 'signup');
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
						</div>
					</div> <!-- first_view_block -->
					<!-- appeal_block -->
					<!-- appeal_block -->
					<!-- appeal_block -->
					<!-- appeal_block -->
				</div>
			</div>
			<!-- footer -->
		</div>
		<!-- jQueryプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/jquery-1.9.1-min.js"></script>
		<!-- 自作プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/common.js"></script>

			<?php 
			if($_SERVER["HTTP_HOST"] == "localhost") {
				
			}
				else {?>
					<!-- アナリティクス -->
					<script>
						(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
						(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
						m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
						})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
						
						ga('create', 'UA-48147923-1', 'sharetube.jp');
						ga('require', 'displayfeatures');
						ga('send', 'pageview');
					</script>
				<?php 
				} ?>
	</body>
</html>
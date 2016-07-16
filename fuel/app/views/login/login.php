<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml" lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
		<meta name='robots' content='noindex,nofollow'>
		<title>ログイン | <?php echo TITLE; ?></title>
		<!-- css -->
		<link rel="stylesheet" href="http://sharetube.jp/assets/css/common/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/login/common.css" type="text/css">
	</head>
	<body>
		<!--  -->
		<div class="login">
			<h1 class="text_center"><a href="<?php echo Uri::base(); ?>" title="Powered by Programmerbox"><img width="160" height="61" alt="シェアチューブ" src="<?php echo Uri::base(); ?>assets/img/logo/logo_27.png"></a></h1>
			<!-- login_form -->
			<form class="login_form" name="login_form" action="" method="post">
				<!-- block -->
				<div class="block">
					<p class="m_0">
						<label for="user_login">ユーザー名 or メールアドレス
					</p>
							<input type="text" class="input" id="user_login" name="login_user" value="" size="20">
						</label>
				</div>
				<!-- block -->
				<div class="block">
					<p class="m_0">
						<label for="user_pass">パスワード
					</p>
							<input type="password" class="input" id="user_pass" name="login_pass" value="" size="20">
						</label>
				</div>
				<!-- submit -->
				<p class="submit clearfix">
					<input type="submit" class="login_button" name="login_submit" value="ログイン">
				</p>
			</form>
			<!--  -->
			<!--
			<p><a href="<?php echo Uri::base(); ?>" title="">&larr; Programmerbox へ戻る</a></p>
			-->
			<?php echo $content_data["login_message"]; ?>
		</div>
	</body>
</html>
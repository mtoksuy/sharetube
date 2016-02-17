<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml" lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name='robots' content='noindex,nofollow'>
		<title><?php echo $view_data["title"]; ?></title>
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/common/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/login/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/matome/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/library/sweetalert-master/dist/sweetalert.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/library/typicons.2.0.7/font/typicons.css" type="text/css">

	</head>
	<body>
		<!--  -->
		<div class="admin">
			<div class="admin_left">
				<div class="admin_left_menu">
					<a href="<?php echo Uri::base(); ?>login/admin/">ダッシュボード</a>
					<a href="<?php echo Uri::base(); ?>channel/<?php echo $_SESSION['sharetube_id']; ?>/" target="_blank">マイページ</a>
				</div>







				<!--  -->
				<div class="admin_left_menu">
					<ol>
						<li>
							<dl>
								<dt>投稿</dt>
								<dd><a href="<?php echo Uri::base(); ?>login/admin/matome/" target="_blank">まとめ作成</a></dd>
								<?php if($_SESSION["sharetube_id"] == 'mtoksuy') { echo '<dd><a href="'.Uri::base().'login/admin/post/">新規追加(廃止)</a></dd>'; } ?>
								<dd><a href="<?php echo Uri::base(); ?>login/admin/list/">投稿一覧</a></dd>
								<dd><a href="<?php echo Uri::base(); ?>login/admin/draft/list/">下書き一覧</a></dd>
								<dt>アナリティクス</dt>
								<dd><a href="<?php echo Uri::base(); ?>login/admin/analytics/">サマリー(30日間)</a></dd>
								<dd><a href="<?php echo Uri::base(); ?>login/admin/analytics/limit/30/new_articles/">サマリー(新着のみ)</a></dd>
								<dt>インセンティブ</dt>
								<dd><a href="<?php echo Uri::base(); ?>login/admin/incentive/">インセンティブ</a></dd>




								<?php if($_SESSION["sharetube_id"] == 'mtoksuy') { echo '<dt>マスター専用</dt>';} ?>
								<?php if($_SESSION["sharetube_id"] == 'mtoksuy') { echo '<dd><a href="'.Uri::base().'login/admin/decoration/">装飾CSSコピー</a></dd>'; } ?>
								<?php if($_SESSION["sharetube_id"] == 'mtoksuy') { echo '<dd><a href="'.Uri::base().'permalink/image_html_generate.php/">連続画像HTML生成</a></dd>'; } ?>
								<?php if($_SESSION["sharetube_id"] == 'mtoksuy') { echo '<dd><a href="'.Uri::base().'login/admin/imageupload/">画像アップロード</a></dd>'; } ?>
								<?php if($_SESSION["sharetube_id"] == 'mtoksuy') { echo '<dd><a href="'.Uri::base().'login/admin/access/">アクセスランキング</a></dd>'; } ?>
								<?php if($_SESSION["sharetube_id"] == 'mtoksuy') { echo '<dd><a href="'.Uri::base().'login/admin/twitterscraping/">Twitter・Tweet埋め込みツール Var.1.00</a></dd>'; } ?>
								<?php if($_SESSION["sharetube_id"] == 'mtoksuy') { echo '<dd><a href="'.Uri::base().'login/admin/incentiveticket/">インセンティブチケット</a></dd>'; } ?>


								<dt>アカウント</dt>
								<dd><a href="<?php echo Uri::base(); ?>login/admin/userprofileedit/">プロフィール編集</a></dd>
								<dd><a href="<?php echo Uri::base(); ?>login/admin/userbankedit/">振込先編集</a></dd>




								<?php if($_SESSION["sharetube_id"] == 'mtoksuy') { 
									echo '<dt>Root</dt>';
									echo '<dd><a href="'.Uri::base().'login/admin/root/list/">投稿一覧</a></dd>';
									echo '<dd><a href="'.Uri::base().'login/admin/root/draft/list/">下書き一覧</a></dd>';
									echo '<dt>便利機能</dt>';
									echo '<dd><a href="'.Uri::base().'login/admin/sitemap/">Sitemap.xml生成</a></dd>';

 } ?>
							</dl>
						</li>
					</ol>
				</div>
				<!-- 後で使う -->
				<div class="admin_left_menu">
					
				</div>
			</div>
			<!--  -->
			<div class="admin_right">
				<div class="admin_right_block_logout">
					<a href="<?php echo Uri::base(); ?>login/admin/logout/">ログアウト</a>
				</div>
					<?php echo $view_data["content"]; ?>
			</div>
		</div>

		<!-- jQueryプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/jquery-1.9.1-min.js"></script>

		<!-- sweetalert-devプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/library/sweetalert-master/dist/sweetalert-dev.js"></script>

		<!-- commonプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/common.js"></script>
		<!-- loginプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/common.js"></script>
		<!-- matomeプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/common.js"></script>
		<!-- userprofileeditプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/userprofileedit/common.js"></script>
		<!-- Twitterscrapingプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/twitterscraping/common.js"></script>
		<!-- analyticsプラグイン -->
		<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart']}]}"></script>
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/analytics/common.js"></script>





		<!-- Twitterプラグイン -->
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</body>
</html>
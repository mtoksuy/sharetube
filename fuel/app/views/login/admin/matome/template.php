<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml" lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
		<meta name='robots' content='noindex,nofollow'>
		<title><?php echo $view_data["title"]; ?></title>
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/common/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/login/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/login/matome/common.css" type="text/css">

		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/library/typicons.2.0.7/font/typicons.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/library/sweetalert-master/dist/sweetalert.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/library/flickity.1.1.1/flickity.css" type="text/css" media="screen">


	</head>
	<body>
		<!--  -->
		<div class="admin">

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

		<!-- jQuery autosize プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/library/jquery.autosize-min.js"></script>

		<!-- sweetalert-devプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/library/sweetalert-master/dist/sweetalert-dev.js"></script>

		<!-- jquery.selection プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/library/jquery.selection.js"></script>

		<!-- commonプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/common.js"></script>
		<!-- loginプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/common.js"></script>
		<!-- Twitterscrapingプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/twitterscraping/common.js"></script>

		<!-- matomeプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/common.js"></script>

		<!-- matome 見出し プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/title.js"></script>
		<!-- matome テキスト プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/text.js"></script>
		<!-- matome 引用 プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/quote.js"></script>
		<!-- matome twitter プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/twitter.js"></script>
		<!-- matome video プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/video.js"></script>
		<!-- matome image プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/image.js"></script>
		<!-- matome link プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/link.js"></script>
		<!-- matome amazon プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/amazon.js"></script>
		<!-- matome amazon_review プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/amazon_review.js"></script>
		<!-- matome timeline プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/timeline.js"></script>
		<!-- matome heading_image プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/heading_image.js"></script>
		<!-- matome code プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/code.js"></script>
		<!-- matome itunes_app プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/itunes_app.js"></script>
		<!-- matome ballon プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/ballon.js"></script>
		<!-- matome enclosed プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/enclosed.js"></script>


		<!-- matome text_design_tool プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/text_count_tool.js"></script>
		<!-- matome text_design_tool プラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/login/matome/text_design_tool.js"></script>

		<!-- Twitterscrapingプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/twitterscraping/common.js"></script>

		<!-- Twitterプラグイン -->
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</body>
</html>
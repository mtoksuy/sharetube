<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $view_data["title"]; ?></title>
		<!-- meta -->
		<?php echo $view_data["meta"]; ?>
		<link rel="shortcut icon" href="<?php echo Uri::base(); ?>assets/img/icon/favicon_1.ico" type="image/vnd.microsoft.icon">
		<link rel="icon" href="<?php echo Uri::base(); ?>assets/img/icon/favicon_1.ico" type="image/vnd.microsoft.icon">
		<link rel="alternate" type="application/rss+xml" title="Sharetube RSSフィード" href="<?php echo Uri::base(); ?>feed.xml">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/common/common.css" type="text/css">
<!--
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/library/jquery.mobile-menu.css" type="text/css">
-->
		<?php echo $view_data["external_css"]; ?>
	</head>
	<body>
		<!-- wrapper -->
		<div id="wrapper">
			<!-- header -->
			<?php echo $view_data["header"]; ?>
			<!-- drawer -->
			<?php echo $view_data["drawer"]; ?>
			<!-- main -->
			<div class="main clearfix">
				<!-- main_contents -->
				<div class="main_contents clearfix">
					<?php echo $view_data["content"]; ?>
				</div>
			</div>
			<!-- footer -->
			<?php echo $view_data["footer"]; ?>
			<?php echo $view_data["script"]; ?>
		</div>
	</body>
</html>

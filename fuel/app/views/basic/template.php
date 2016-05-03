<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $view_data["title"]; ?></title>
		<!-- meta -->
		<?php echo $view_data["meta"]; ?>
		<!-- icon -->
		<link rel="shortcut icon" href="<?php echo Uri::base(); ?>assets/img/icon/favicon_4.ico" type="image/vnd.microsoft.icon">
		<!-- rss -->
		<link rel="alternate" type="application/rss+xml" title="Sharetube RSSフィード" href="<?php echo Uri::base(); ?>feed.xml">
		<!-- css -->
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/common/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/matome/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo HTTP; ?>assets/css/library/typicons.2.0.7/font/typicons.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/library/flickity.1.1.1/flickity.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/js/library/FlexSlider.2/flexslider.css" type="text/css" media="screen">
		<link rel="apple-touch-icon" href="<?php echo Uri::base(); ?>assets/img/icon/apple_touch_icon_1.png" />
		<link rel="apple-touch-icon-precomposed" href="<?php echo Uri::base(); ?>assets/img/icon/apple_touch_icon_1.png" />


		<?php echo $view_data["external_css"]; ?>
	</head>
	<body>
		<!-- wrapper -->
		<div id="wrapper">
			<!-- header -->
			<?php echo $view_data["header"]; ?>
			<!-- mobile_ad -->
			<?php  echo $view_data["mobile_ad"]; ?>
			<!-- drawer -->
			<?php echo $view_data["drawer"]; ?>
			<!-- main -->
			<div class="main clearfix">
				<!-- sp_thumbnail -->
				<?php echo $view_data["sp_thumbnail"]; ?>
				<!-- main_contents -->
				<div class="main_contents clearfix">
					<?php echo $view_data["content"]; ?>
				</div>
				<!-- sidebar -->
				<div class="sidebar">
					<?php echo $view_data["sidebar"]; ?>
				</div>
			</div>
			<!-- footer -->
			<?php echo $view_data["plus_add"]; ?>
			<?php echo $view_data["footer"]; ?>
			<?php echo $view_data["script"]; ?>
		</div>
	</body>
</html>

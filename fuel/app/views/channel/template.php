<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $view_data["title"]; ?></title>
		<!-- meta -->
		<?php echo $view_data["meta"]; ?>
		<!-- icon -->
		<link rel="shortcut icon" href="<?php echo Uri::base(); ?>assets/img/icon/favicon_5.ico" type="image/vnd.microsoft.icon">
		<!-- rss -->
		<link rel="alternate" type="application/rss+xml" title="Sharetube RSSフィード" href="<?php echo Uri::base(); ?>feed.xml">
		<!-- css -->
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/common/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/matome/common.css" type="text/css">


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
				<!-- sidebar -->
				<div class="sidebar">
					<?php echo $view_data["sidebar"]; ?>
				</div>
				<!-- main_contents -->
				<div class="main_contents clearfix">
					<?php echo $view_data["content"]; ?>
				</div>
			</div>
			<!-- footer -->
			<?php echo $view_data["plus_add"]; ?>
			<?php echo $view_data["footer"]; ?>
			<?php echo $view_data["script"]; ?>
		</div>
	</body>
</html>

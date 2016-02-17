
			<!-- jQueryプラグイン -->
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/jquery-1.9.1-min.js"></script>
			<!-- 自作プラグイン -->
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/common.js"></script>
			<!-- Twitterscrapingプラグイン -->
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/twitterscraping/common.js"></script>
			<!-- Twitter_image_viewプラグイン -->
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/article/twitter_image_view.js"></script>

		<!-- flickity プラグイン -->
		<script src="<?php echo HTTP; ?>assets/js/library/flickity.1.1.1/flickity.pkgd.min.js"></script>

		<!-- ピックアップ -->
		<script>
		$('.matome_content_block_itunes_app_data_screenshots').css( {
			'height' :'auto',
			'overflow': 'auto'
		});
		$('.matome_content_block_itunes_app_data_screenshots').flickity({
			freeScroll: true,
			contain: true,
			prevNextButtons: false,
			pageDots: false,
			lazyLoad: true,
		});
		</script>







			<!-- FBページプラグイン -->
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.4";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

			<!-- Twitterプラグイン -->
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			<!-- はてなプラグイン -->
<!--
			<script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
-->
			<!-- Pocketプラグイン -->
<!--
			<script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>
-->
			<!-- グーグル+プラグイン -->
			<script type="text/javascript">
			  window.___gcfg = {lang: 'ja'};
			
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
			<?php 
			if($_SERVER["HTTP_HOST"] == "localhost") {
				
			}
				else {?>
					<!-- アナリティクス -->
<!--
					<script>
					  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
					
					  ga('create', 'UA-48147923-1', 'sharetube.jp');
					  ga('send', 'pageview');
					
					</script>
-->
		<?php 
				} ?>

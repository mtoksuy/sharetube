
			<!-- jQueryプラグイン -->
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/jquery-1.9.1-min.js"></script>
			<!-- 自作プラグイン -->
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/common.js"></script>
			<!-- ajaxローダープラグイン -->
<!--
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/ajax/articleloader.js"></script>
-->
			<!-- flexsliderプラグイン -->
			<script src="<?php echo HTTP; ?>assets/js/library/flexslider.2/jquery.flexslider.js"></script>


			<!-- FBページプラグイン -->
			<div id="fb-root"></div>
			<script>
			(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.4";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));

			</script>
			<!-- Twitterプラグイン -->
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			<!-- はてなプラグイン -->
			<script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
			<!-- Pocketプラグイン -->
			<script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>
			<!-- グーグル+プラグイン -->
			<!-- head 内か、body 終了タグの直前に次のタグを貼り付けてください。 -->
			<script src="https://apis.google.com/js/platform.js" async defer>
			  {lang: 'ja'}
			</script>
			

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


			<!-- jQueryプラグイン -->
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/jquery-1.9.1-min.js"></script>
			<!-- 自作プラグイン -->
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/common.js"></script>
			<!-- ajaxローダープラグイン -->
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/ajax/articleloader.js"></script>
			<!-- flickityプラグイン -->
			<script src="<?php echo HTTP; ?>assets/js/library/flickity.1.1.1/flickity.pkgd.min.js"></script>
			<!-- flexsliderプラグイン -->
			<script src="<?php echo HTTP; ?>assets/js/library/flexslider.2/jquery.flexslider.js"></script>

		<style>
		.flexslider {
	    line-height: 280%;
			overflow: hidden;
		}
		.flexslider figure {
			margin: 0;
		}
		</style>

		<script>
			$(window).load(function() {
				$('.flexslider').flexslider( {
					animation      : 'slide',
					prevText       : '',
					nextText       : '',
					slideshow      : true,
					pauseOnAction  : false,
					pasneOnHover   : true,
					useCSS         : true,
					slideshowSpeed : 5000,
					animationSpeed : 400,
		//			video          : true,
					controlNav     : false,
		//			directionNav   : false,
/*
					itemWidth      : 0,
//    カルーセルを設定した際の画像１枚の幅。デフォルトは0です。
					itemMargin     : 0,
//    カルーセルの画像１枚のマージン。デフォルトは0です。
					minItems       : 2,
//    カルーセルの画像を最低で何枚を一画面に表示するか。デフォルトは0です。
					maxItems      : 2,
//    カルーセルの画像を最大で何枚を一画面に表示するか。デフォルトは0です。
					move      : 0,
//カルーセルの画像をスライドで何枚動かすか。0だと全部動かす。デフォルトは0です。
*/
				});
			});
		</script>

		<!-- ピックアップ -->
		<script>
		$('.main_gallery').css( {
			'height' :'auto',
			'overflow': 'visible',
		});
				
		$('.main_gallery').flickity({
		  // options
//		  cellAlign: 'left',
			cellAlign: 'center',
			contain: true,
//			lazyLoad: true,
			freeScroll: true,
			<?php 
				// モバイル判別するPHPクラスライブラリを利用した機種判別
				$detect = Model_info_Basis::mobile_detect_create();
				// スマホ&タブレットの場合ボタンを非表示にする
				if($detect->isMobile() | $detect->isTablet()) {
					echo 'prevNextButtons: false,
								wrapAround: false,
								pageDots: false,
';
				}
					else {
						echo 'prevNextButtons: true,
									wrapAround: true,
									pageDots: false,
';
					}
			?>
		});
		</script>

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

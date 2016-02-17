
<!--
<div class="mobile_header_ad">
	<div class="mobile_header_ad_content">
		<img src="http://localhost/sharetube/assets/img/common/test_2.jpg">
	</div>
</div>
-->

<!--
<div class="mobile_orverlay_ad">
	<div class="mobile_orverlay_ad_content">
		<img src="http://localhost/sharetube/assets/img/common/test_2.jpg">
	</div>
</div>
-->

<?php
		// 広告配信
		$detect  = Model_info_Basis::mobile_detect_create();
		// Fluct広告
		$ad_mobile_deader_html   = Model_Ad_Html::fluct_ad_html_create($detect, 'none', 'ヘッダー');
		$ad_mobile_orverlay_html = Model_Ad_Html::fluct_ad_html_create($detect, 'none', 'オーバーレイ');


		// 記事内トップ広告分け
		if($detect->isMobile()) {
			$ad_mobile_deader_html = 
			'<div class="mobile_header_ad">
				<div class="mobile_header_ad_content">
					'.$ad_mobile_deader_html.'
				</div>
			</div>';
/*
			$ad_mobile_orverlay_html = 
			'<div class="mobile_orverlay_ad">
				<div class="mobile_orverlay_ad_content">
					'.$ad_mobile_orverlay_html.'
				</div>
			</div>';
*/
		}
			else if($detect->isTablet()) {
				echo 'てすと';
				$ad_mobile_deader_html = 
				'<div class="mobile_header_ad">
					<div class="mobile_header_ad_content">
	
					</div>
				</div>';

				$ad_mobile_orverlay_html = 
				'<div class="mobile_orverlay_ad">
					<div class="mobile_orverlay_ad_content">
				
					</div>
				</div>';
			}
				else {
					$ad_mobile_deader_html = 
					'<div class="mobile_header_ad">
						<div class="mobile_header_ad_content">
		
						</div>
					</div>';

					$ad_mobile_orverlay_html = 
					'<div class="mobile_orverlay_ad">
						<div class="mobile_orverlay_ad_content">
					
						</div>
					</div>';
				}
			echo $ad_mobile_deader_html;
			echo $ad_mobile_orverlay_html;

/*

			<!-- mobile_ad -->
			<div class="mobile_ad clearfix">
				<div class="mobile_ad_contents clearfix">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- Sharetubeモバイルバナー -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:320px;height:50px"
					     data-ad-client="ca-pub-0450119979424968"
					     data-ad-slot="2250160851"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>	
				</div>
			</div>
*/
?>

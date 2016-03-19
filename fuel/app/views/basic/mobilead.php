
<?php
		// 広告配信
		$detect  = Model_info_Basis::mobile_detect_create();
		// Fluct広告
		$ad_mobile_deader_html   = Model_Ad_Html::fluct_ad_html_create($detect, 'none', 'ヘッダー');
		$ad_mobile_orverlay_html = Model_Ad_Html::fluct_ad_html_create($detect, 'none', 'オーバーレイ');
		// 2月20日スタート 3月30日エンド
//		$ad_mobile_orverlay_html = Model_Ad_Html::techno_arcadia_ad_html_create($detect, 'none', 'オーバーレイ');
//		var_dump($ad_mobile_orverlay_html);

		// 記事内トップ広告分け
		// モバイル
		if($detect->isMobile()) {
			// ヘッダー
			$ad_mobile_deader_html = 
			'<div class="mobile_header_ad">
				<div class="mobile_header_ad_content">
					'.$ad_mobile_deader_html.'
				</div>
			</div>';
			// オーバーレイ
			$ad_mobile_orverlay_html = 
				'<div class="mobile_orverlay_ad">
					<div class="mobile_orverlay_ad_content">
						'.$ad_mobile_orverlay_html.'
					</div>
				</div>';
		}
			// タブレット
			else if($detect->isTablet()) {
				$ad_mobile_deader_html = 
				'<div class="mobile_header_ad">
					<div class="mobile_header_ad_content">
	
					</div>
				</div>';

			// オーバーレイ
			$ad_mobile_orverlay_html = 
				'<div class="mobile_orverlay_ad">
					<div class="mobile_orverlay_ad_content">
						'.$ad_mobile_orverlay_html.'
					</div>
				</div>';
			}
			// PC(初期化)
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
?>

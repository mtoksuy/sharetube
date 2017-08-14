
<?php 
		// 広告配信
		$detect  = Model_info_Basis::mobile_detect_create();
		// Fluct広告
//		$ad_mobile_deader_html   = Model_Ad_Html::fluct_ad_html_create($detect, 'none', 'ヘッダー');
//		$ad_mobile_orverlay_html = Model_Ad_Html::fluct_ad_html_create($detect, 'none', 'オーバーレイ');

		// 全ての広告別array取得
		$all_ad_html_array = Model_Ad_Html::all_ad_html_array_get();
		// アドネットワークをランダムで取得
		$ad_network_name = Model_Ad_Basis::ad_network_random_get(array('fluct', 'geniee'));
		// 広告ネットワーク指定アドhtml生成
		$ad_mobile_orverlay_html   = Model_Ad_Html::all_ad_html_create($all_ad_html_array, $detect, 'fluct', $ad_network_name, 'none', 'オーバーレイ');

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

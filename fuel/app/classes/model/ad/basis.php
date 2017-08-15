<?php 
class Model_Ad_Basis extends Model {
	//--------------------------------
	//アドネットワークをランダムで取得
	//--------------------------------
	public static function ad_network_random_get($ad_network_array) {
//		$input           = array('fluct', 'geniee');
		$rand_keys       = array_rand($ad_network_array);
		$ad_network_name = $ad_network_array[$rand_keys];
		return $ad_network_name;
	}
	//----------------------------------------------------
	//インタースティシャルを許可するテーマだけ広告配信取得
	//----------------------------------------------------
	public static function interstitial_permission_theme_ad_html_get($tag_array, $ad_article_interstitial_html) {
		$return_ad_article_interstitial_html = '';
//		pre_var_dump($tag_array);
		// インターステイシャルを許可するテーマ名
		$save_array = array(
			'怖い話',
			'洒落怖',
			'洒落にならない怖い話',
			'オカルト',
			'怪談',
			'コピペ',
			'都市伝説',
			'犯罪者',
			'セクシー',
			'閲覧注意',
			'殺人事件',
			'犯罪',
			'恐い話',
			'エロ',
			'逮捕',
			'戦争',
			'放射能汚染',
			'グラドル',
			'放射能',
			'安倍政権',
			'原発',
			'事件・事故',
			'自殺',
			'都知事選',
			'不倫',
			'不正選挙',
			'炎上',
			'意味が分かるとこわい話',
			'テロ',
			'真実',
			'ブラック企業',
			'人工地震',
			'災害',
			'癌',
			'お酒',
			'安倍晋三',
			'殺人',
			'死亡',
			'訃報',
			'こわい画像',
			'真相',
			'性的な話',
			'松居一代',
			'２ｃｈ',
			'安倍自民',
			'未解決事件',
			'違法',
			'セシウム',
			'ホラー',
			'原発事故',
			'整形',
			'３１１',
			'すっきりする話',
			'すかっとする話',
			'コラージュ',
			'貧困',
			'ハゲ',
			'殺人鬼',
			'浮気',
			'バイアグラ',
			'心霊写真',
			'殺害',
			'死刑',
			'事件と事故',
			'レイプ',
			'洗脳',
			'狂気',
			'怖い画像',
			'腐女子',
			'売春',
			'おっぱい',
			'暴露',
			'検索してはいけない言葉',
			'凶悪事件',
			'死体遺棄',
			'いじめ',
			'偽旗作戦',
			'スケベ',
			'セックス',
			'福島原発事故',
			'偏向報道',
			'酒',
			'萌え',
			'ねつ造',
			'怖いサイコパス',
			'脱原発',
		);
		foreach($tag_array as $key_1 => $value_1) {
			foreach($save_array as $key_2 => $value_2) {
				if( preg_match('/'.$value_1.'/i', $value_2)) {
					$return_ad_article_interstitial_html = 
						'<div class="m_t_15 m_b_15 text_center">'
							.$ad_article_interstitial_html.
						'</div>';
				}
			}
		}
		return $return_ad_article_interstitial_html;
	}
















}
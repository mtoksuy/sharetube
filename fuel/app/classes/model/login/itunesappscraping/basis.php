<?php 

/**
 * iTunes_app_スクレイピング関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Itunesappscraping_Basis extends Model {
	//-------------------------
	//iTunes_app_スクレイピング
	//-------------------------
	public static function itunes_app_scraping($itunes_app_url) {

/*
          <div id="title" class="intro ">
            <div class="left">
              <h1 itemprop="name">セブン‐イレブンアプリ</h1>
              <h2>開発: Seven-Eleven Japan Co., Ltd.</h2>

    <p itemprop="description">セブン‐イレブンアプリは、お客様にセブン‐イレブンこだわりの商品や、<br />お得なキャンペーン情報などをお届けします。ぜひお楽しみください。<br />また、「無料Wi‐Fiサービス セブンスポット」にアプリから接続した場合、<br />1日に1時間×3回までの回数制限をなくし、回数無制限でご利用可能です。<br /><br />＜主な機能＞<br />○ 「商品」<br />お客様が設定した地域に合わせた、新商品情報やセブン‐イレブンオリジナル商品、季節の商品をお届けします。<br /><br />○ 「無料Wi‐Fiサービス セブンスポット」<br />セブン‐イレブンアプリからセブンスポットに接続した場合、<br />1日に1時間×3回までの回数制限をなくし、回数無制限でご利用可能です。<br /><br />※セブンスポットキャンペーンや、コンテンツをご利用の場合は、<br />  ブラウザを起動して「http://webapp.7spot.jp/」にアクセスをお願いします。<br /><br />○「キャンペーン」<br />お得なキャンペーン情報をご紹介します。<br /><br />○「ショッピング」<br />お客様が、「いつどこにいても欲しい商品とつながる世の中」。7&iグループの「すべてのお店・すべての商品」と「お客様」を繋げます。<br /><br />＜推奨環境（2015/8時点）＞<br />iOS：iOS 7以降</p>


<div itemprop="price" content="0" class="price">無料</div>
<span itemprop="applicationCategory">ライフスタイル</span>
<span itemprop="datePublished" content="2015-10-05 06:24:44 Etc/GMT">2015年10月5日 </span>
<span itemprop="softwareVersion">1.0.0</span>
</li><li><span class="label">サイズ : </span>6.4 MB</li>
<span itemprop="operatingSystem">iOS 7.0 以降。iPhone、iPad、および iPod touch に対応。</span></p>
<span style="display: none;" itemprop="ratingValue">3.2</span>
*/


/*
2パターンで取得できる
	 $title_html .= $list->plaintext;
	 $title_html .= $list->outertext;
*/

		// simple_html_domライブラリ読み込み
		require_once INTERNAL_PATH.'fuel/app/classes/library/simplehtmldom_1_5/simple_html_dom.php';

		// URLから
		$simple_html_dom_object = file_get_html($itunes_app_url);




		// タイトル取得
		foreach($simple_html_dom_object->find('h1[itemprop=name]') as $list) {
			 $title_html .= $list->plaintext;
		}
		// 開発元取得
		foreach($simple_html_dom_object->find('.intro') as $list) {
			 $developer_html .= $list->outertext;
		}
		// object生成
		$developer_object = str_get_html($developer_html, true, true, DEFAULT_TARGET_CHARSET, false);
		foreach($developer_object->find('h2') as $list) {
			 $developer_html = $list->plaintext;
		}
		$developer_html = preg_replace('/開発: /', '', $developer_html);

		// 概要取得
		foreach($simple_html_dom_object->find('[itemprop=description]') as $list) {
			 $description_html .= $list->plaintext;
		}
		// 値段取得
		foreach($simple_html_dom_object->find('[itemprop=price]') as $list) {
			$price_html .= $list->plaintext;
		}
//		$price_html = preg_replace('/¥/','',$price_html);

		// カテゴリー取得
		foreach($simple_html_dom_object->find('[itemprop=applicationCategory]') as $list) {
			$category_html .= $list->plaintext;
		}
		// リリース日取得
		foreach($simple_html_dom_object->find('[itemprop=datePublished]') as $list) {
			$release_date_html .= $list->plaintext;
		}
		$release_date_html = preg_replace('/ /','',$release_date_html);

		// ヴァージョン取得
		foreach($simple_html_dom_object->find('[itemprop=softwareVersion]') as $list) {
			$version_html .= $list->plaintext;
		}
		// サイズ取得
		foreach($simple_html_dom_object->find('.list') as $list) {
			$size_html .= $list->plaintext;
		}
		preg_match('/サイズ : (.*?)(B|KB|MB|GB)/',$size_html, $size_array);
		$size_html = $size_array[1].$size_array[2];

		// 対応iOS情報取得
		foreach($simple_html_dom_object->find('[itemprop=operatingSystem]') as $list) {
			$system_cover_html .= $list->plaintext;
		}
		$system_cover_html = substr($system_cover_html, 0, -1);   //最後の「 」を削除

		// 評価取得
		foreach($simple_html_dom_object->find('[itemprop=ratingValue]') as $list) {
			$rating_html .= $list->plaintext;
		}
		$rating_html = substr($rating_html, 0, -1);   //最後の「 」を削除
		// 評価が集まっていないアプリ用
		if($rating_html == false) {
			foreach($simple_html_dom_object->find('.customer-ratings') as $list) {
				$rating_html .= $list->outertext;
			}
			$pattern_half = '/rating-star half/';
			$pattern_ghost = '/rating-star ghost/';
			preg_match_all($pattern_half, $rating_html, $rating_half_html_array);
			preg_match_all($pattern_ghost, $rating_html, $rating_ghost_html_array);
			$half_i = 0;
			$ghost_i = 0;
			foreach($rating_half_html_array[0] as $key => $value) {
				$half_i++;
			}
			foreach($rating_ghost_html_array[0] as $key => $value) {
				$ghost_i++;
			}
			$rating_html = (5-$ghost_i)-($half_i*0.5);
		}


		// 評価カウント取得
		foreach($simple_html_dom_object->find('.rating-count') as $list) {
			$rating_count_html = $list->plaintext;
		}
		$rating_count_html = preg_replace('/の評価 /','',$rating_count_html);

		// アイコン取得
/*
		foreach($simple_html_dom_object->find('[property=og:image:secure_url]') as $list) {
			$icon_html .= $list->outertext;
		}

		var_dump($icon_html);
		preg_match('/content="(.*?)"/',$icon_html,$icon_array);
		$icon_html = array($icon_array[1]);
		var_dump($icon_html);
*/
$icon_html = null;
		if($icon_html == null) {
			foreach($simple_html_dom_object->find('.artwork') as $list) {
				$icon_html .= $list->outertext;
			}
			preg_match_all('/content="(.*?)"/',$icon_html, $icon_html_array);
			$icon_html = $icon_html_array[1];
		}









		// スクリーンショット取得
		foreach($simple_html_dom_object->find('.toggle') as $list) {
			$screen_shots_html .= $list->outertext;
		}

		if($screen_shots_html) {
			// $screen_shots_html_object生成
			$screen_shots_html_object = str_get_html($screen_shots_html, true, true, DEFAULT_TARGET_CHARSET, false);
			foreach($screen_shots_html_object->find('.iphone-screen-shots') as $list) {
				$iphone_screen_shots_html .= $list->outertext;
			}
			preg_match_all('/src="(.*?)"/',$iphone_screen_shots_html,$iphone_screen_shots_array);
		}
			else {
				foreach($simple_html_dom_object->find('.content') as $list) {
					$screen_shots_html .= $list->outertext;
				}
				$screen_shots_html_object = str_get_html($screen_shots_html, true, true, DEFAULT_TARGET_CHARSET, false);
				foreach($screen_shots_html_object->find('.lockup') as $list) {
					$iphone_screen_shots_html .= $list->outertext;
				}
				// 謎の画像削除
				$iphone_screen_shots_html = str_replace('src="https://s.mzstatic.com/htmlResources/41C8/frameworks/images/p.png"', "", $iphone_screen_shots_html);
				preg_match_all('/src="(.*?)"/',$iphone_screen_shots_html,$iphone_screen_shots_array);
//				var_dump($iphone_screen_shots_array);
			}


		// app_data_array生成
		$itunes_app_data_array = array();
		$itunes_app_data_array['itunes_app_url'] = $itunes_app_url;
		$itunes_app_data_array['title']          = $title_html;
		$itunes_app_data_array['developer']      = $developer_html;
		$itunes_app_data_array['description']    = $description_html;
		$itunes_app_data_array['price']          = $price_html;
		$itunes_app_data_array['category']       = $category_html;
		$itunes_app_data_array['release_date']   = $release_date_html;
		$itunes_app_data_array['version']        = $version_html;
		$itunes_app_data_array['size']           = $size_html;
		$itunes_app_data_array['system_cover']   = $system_cover_html;
		$itunes_app_data_array['rating']         = $rating_html;
		$itunes_app_data_array['rating_count']   = $rating_count_html;
		$itunes_app_data_array['icon']           = $icon_html;
		$itunes_app_data_array['screen_shots']   = $iphone_screen_shots_array[1];
//		var_dump($itunes_app_data_array);


		/////////////////////////////////////////////////////
		//iconメディア(icon)データベース登録&ファイル書き込み
		/////////////////////////////////////////////////////
		$image_media_array	 = Model_Login_Itunesappscraping_Basis::media_run($itunes_app_data_array, 'icon');
		$itunes_app_data_array["icon_run"] = $image_media_array;


		/////////////////////////////////////////////////////////////////////
		//screen_shotsメディア(screen_shots)データベース登録&ファイル書き込み
		/////////////////////////////////////////////////////////////////////
		$image_media_array	 = Model_Login_Itunesappscraping_Basis::media_run($itunes_app_data_array, 'screen_shots');
		$itunes_app_data_array["screen_shots_run"] = $image_media_array;

		//開放
		$simple_html_dom_object->clear();
		// 変数破棄
		unset($simple_html_dom_object);
		return $itunes_app_data_array;
	}
	//---------------------------------------------
	//画像メディアデータベース登録&ファイル書き込み
	//---------------------------------------------
	public static function media_run($itunes_app_data_array, $media_type = 'icon') {
		$image_media_array = array();

		// 画像メディア分を実行
		foreach($itunes_app_data_array[$media_type] as $key => $value) {
			// 拡張子取得
			$type_str = substr($value, strrpos($value, '.') + 1);
			// 置換（jpeg→jpg）
			$extension = str_replace("jpeg","jpg", $type_str);

			// データベース登録
			$res = DB::query("
				INSERT INTO itunes_media (
					sharetube_id, 
					itunes_type,
					media_type,
					extension
				)
				VALUES (
					'".$_SESSION["sharetube_id"]."', 
					'app',
					'".$media_type."',
					'".$extension."'
				)")->execute();

			// ファイルネーム
			$file_name = $res[0].'.'.$extension;
			$curl_session = curl_init(); // cURL セッション初期化
			curl_setopt($curl_session, CURLOPT_URL, $value); // 取得する URL 。curl_init() でセッションを 初期化する際に指定することも可能です。 
			curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true); // TRUE を設定すると、curl_exec() の返り値を 文字列で返します。通常はデータを直接出力します。
			$data = curl_exec($curl_session); // cURL セッションを実行する
//			var_dump($data);

			// データを指定した場所に書き込み(重要)
			file_put_contents(PATH.'assets/img/itunes/app/'.$file_name, $data);
			curl_close(); // cURL セッションを閉じる
			// データベース登録&ファイル書き込みした画像array
			$image_media_array[$key] = $file_name;
		} // foreach($itunes_app_data_array["image_media"] as $key => $value) {
//		var_dump($image_media_array);
		return $image_media_array;
	}

}

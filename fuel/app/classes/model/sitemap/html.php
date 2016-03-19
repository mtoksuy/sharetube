<?php
/*
* 
* サイトマップHTML関連クラス
* 
* 
* 
*/

class Model_Sitemap_Html extends Model {
	//------------------------------
	//サイトマップまとめ一覧HTML生成
	//------------------------------
	static function sitemap_list_html_create($category_all_article_array) {
//		var_dump($category_all_article_array);
		$sitemap_list_mastr_html = "";
		$sitemap_list_html       = "";
		$sitemap_article_html    = "";
		// カテゴリー抽出
		foreach($category_all_article_array as $key_1 => $value_1) {
			$sitemap_list_html = '<li class="sitemap_category"><span class="typcn typcn-folder"></span><a href="'.HTTP.$value_1["category_segment"].'/">'.$value_1["category_name"].'</a>';
			// article抽出
			foreach($category_all_article_array[$key_1] as $key_2 => $value_2) {
				// 魔法
				if(strlen($value_2["title"]) > 15) {
					$sitemap_article_html	.= '
						<li class="sitemap_category_article"><span class="typcn typcn-document-text"></span><a href="'.HTTP.'article/'.$value_2["link"].'/">'.$value_2["title"].'</a></li>';
				}
			}
			// 合体
			$sitemap_list_mastr_html .= 
			''.$sitemap_list_html.'
				<ul>
					'.$sitemap_article_html.'
				</ul>
			</li>';
			// 初期化
			$sitemap_article_html = "";
		}
		return $sitemap_list_mastr_html;
	}
	//--------------------
	//サイトマップHTML生成
	//--------------------
	public static function sitemap_html_create($sitemap_list_mastar_html) {
		$sitemap_html = 
			'<div class="article_list">
				<div class="article_list_contents">
					<div class="sitemap">
						<a href="http://sharetube.jp/sitemap/"><h1>サイトマップ</h1></a>
						<p>自動で最新のサイトマップに更新されます。</p>
						<ul class="sitemap_content">
							<h2 class="heading_3">トップページ</h2>
							<li class="sitemap_content_home"><span class="typcn typcn-home-outline"></span><a href="http://sharetube.jp/">Sharetube</a></li>
							<h2 class="heading_3">Sharetubeについて</h2>
							<li><span class="typcn typcn-document-text"></span><a href="'.HTTP.'about/">Sharetubeについて</a></li>
							<li><span class="typcn typcn-document-text"></span><a href="'.HTTP.'contact/">お問い合わせ</a></li>
							<li><span class="typcn typcn-document-text"></span><a href="'.HTTP.'permalink/recruitment_ads.php">広告掲載について</a></li>
							<li><span class="typcn typcn-document-text"></span><a href="'.HTTP.'signup/">まとめ作成</a></li>
							<li><span class="typcn typcn-document-text"></span><a href="'.HTTP.'signup/">Sharetubeアカウント作成</a></li>
							<li><span class="typcn typcn-document-text"></span><a href="'.HTTP.'login/" target="_blank">ログイン</a></li>
							<li><span class="typcn typcn-document-text"></span><a href="'.HTTP.'curatorrecruitment/">キュレーター募集</a></li>
							<li><span class="typcn typcn-document-text"></span><a href="'.HTTP.'curatorrecruitment/lp/">業界NO.1のインセンティブ報酬</a></li>
							<li><span class="typcn typcn-document-text"></span><a href="'.HTTP.'permalink/ch_thread_design_1.php">2ちゃんねるスレッドテキストベースまとめツール Var.1.00</a></li>
							<h2 class="heading_3">コンテンツ</h2>
							'.$sitemap_list_mastar_html.'
						</ul>
					</div>
				</div>
			</div>';
		return $sitemap_html;
	}
}
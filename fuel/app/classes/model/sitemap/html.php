<?php
/*
* 
* サイトマップHTML関連クラス
* 
* 
* 
*/

class Model_Sitemap_Html extends Model {
	//--------------------
	//サイトマップHTML生成
	//--------------------
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
}
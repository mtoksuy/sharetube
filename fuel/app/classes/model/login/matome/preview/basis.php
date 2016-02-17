<?php 

/**
 * まとめ・プレビュー関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Matome_Preview_Basis extends Model {
	//------------------------------
	//まとめコンテンツリストHTML取得
	//------------------------------
	static function matome_content_block_list_html_get($article_html) {
		/*
			解決しました
			PHP Simple HTML DOM Parserで改行コードが削除される問題
			http://matomerge.com/simple-html-dom-parser-trouble/
			
			str_get_htmlの場合
			str_get_html($article_html, true, true, DEFAULT_TARGET_CHARSET, false);
			
			file_get_htmlの場合
			file_get_html($file, false, null, -1, -1, true, true, DEFAULT_TARGET_CHARSET, false);
		*/
		// simple_html_domライブラリ読み込み
		require_once INTERNAL_PATH.'fuel/app/classes/library/simplehtmldom_1_5/simple_html_dom.php';
		// dom生成
		$article_html = str_get_html($article_html, true, true, DEFAULT_TARGET_CHARSET, false); // 文字列から
		// 挿入する変数
		$matome_content_block_list_html = '';
		// matome_content_blockのみ取得
		foreach($article_html->find('.matome_content_block') as $list) {
			 $matome_content_block_list_html .= $list->outertext;
		}
		//開放
		$article_html->clear();
		// 変数破棄
		unset($article_html);
//		var_dump($matome_content_block_list_html);
		return $matome_content_block_list_html;
	}
}
?>
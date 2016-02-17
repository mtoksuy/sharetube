<?php
/*
* Ajaxコントローラー
* 
* 
* 
*/
class Controller_Ajax_Articleloader extends Controller {
	// アクション
	public function action_index() {
		// 変数
		$article_number   = $_GET["article_number"];
		$category_segment = $_GET["category_segment"];
		// 記事タイプ取得
		switch($category_segment) {
			case 'vine':
				$article_type = 'vine';
			break;
			default:
				$article_type = 'article';
			break;
		}
		$category_info_array = Model_Info_Basis::segment_category_info_get($category_segment);
		$segment_info_get_array = array(
			'segment'        => $category_info_array["category_segment"],
			'category_name'  => $category_info_array["category_name"],
			'paging_segment' => 0,
		);
		// 記事一覧データ取得
		$list_query = Model_Article_Basis::list_get($segment_info_get_array, 10, $article_number, $article_type);
		// 記事一覧HTML生成
		$article_list_html = Model_Article_Html::list_html_create($list_query, $article_type);

		//ビュー読み込み
		$ajax_view = View::forge('ajax/articleloader');
		// データセット
		$ajax_view->set('ajax_data', array(
			'article_number'      => $article_number,
			'category_info_array' => $category_info_array,
			'article_list_html'   => $article_list_html,
		), false);
		return $ajax_view;
	}
}

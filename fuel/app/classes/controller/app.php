<?php
/*
* Rootコントローラー
*
* トップページとカテゴリをコントロール。
*
*/
class Controller_App extends Controller_App_Template {
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	// 基本アクション
	public function action_index() {
		// セグメント情報取得
		$segment_info_get_array = Model_Info_Basis::segment_info_get();
		// タイトルセット
		$this->basic_template->view_data["title"] = $segment_info_get_array["title_segment"].TITLE;

		// メタセット(トップのみ)
		if($segment_info_get_array["top_judgment"] == true) {
			$this->basic_template->view_data["meta"] = View::forge('root/meta');
		}
		// 記事一覧データ取得
		$list_query        = Model_Article_Basis::list_get($segment_info_get_array);
		// 記事一覧HTML生成
		$article_list_html = Model_Article_Html::app_list_html_create($list_query);
		// コンテンツデータセット
		$this->basic_template->view_data["content"]->set('content_data', array(
			'content_html' => $article_list_html,
		), false);
		// フッター変更
//		$this->basic_template->view_data["footer"] = View::forge('root/footer');
	}
}

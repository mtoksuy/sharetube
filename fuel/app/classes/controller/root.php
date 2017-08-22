<?php
/*
* Rootコントローラー
*
* トップページとカテゴリをコントロール
*
*/

class Controller_Root extends Controller_Basic_Template {
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
		// CSSセット
		$this->basic_template->view_data["external_css"] = View::forge('root/externalcss');

		// トップのみ
		if($segment_info_get_array["top_judgment"] == true) {
/*
			var_dump(md5('work_shop_6'));
			var_dump(md5('bee330f7a9a560b8e63790c071f9ffb4'));

*/



			// メタセット
			$this->basic_template->view_data["meta"] = View::forge('root/meta');
			// 注目まとめ一覧データ取得
			$recommend_article_array             = Model_Article_Basis::recommend_article_list_get(20,1);
			// 注目まとめ一覧HTML生成
			$recommend_article_html              = Model_Article_Html::recommend_article_list_html_create($recommend_article_array);
			// 注目まとめページングデータ取得
			$recommend_article_paging_data_array = Model_Article_Basis::recommend_article_paging_data_get(20, 1);
			// 注目まとめページングHTML生成
			$paging_html                         = Model_Article_Html::recommend_article_paging_html_create($recommend_article_paging_data_array);
			// 注目まとめ一覧HTMLと注目まとめページングHTMLを合体
			$recommend_article_html = $recommend_article_html.$paging_html;


/*
			// 殿堂まとめ一覧データ取得
			$fame_article_array             = Model_Article_Basis::fame_article_list_get(10,1);
			// 殿堂まとめ一覧HTML生成
			$fame_article_html              = Model_Article_Html::recommend_article_list_html_create($fame_article_array, 'article', '殿堂');
			// 殿堂まとめページングデータ取得
			$fame_article_paging_data_array = Model_Article_Basis::fame_article_paging_data_get(10, 1);
			// 殿堂まとめページングHTML生成
			$paging_html                         = Model_Article_Html::recommend_article_paging_html_create($fame_article_paging_data_array);
			// 殿堂まとめ一覧HTMLと殿堂まとめページングHTMLを合体
			$fame_article_html = $recommend_article_html.$fame_article_html.$paging_html;
*/













		}
			// カテゴリーに適用される仕様
			else {
				// スクリプト変更
				$this->basic_template->view_data["script"] = View::forge('root/script');
				// フッター変更
				$this->basic_template->view_data["footer"] = View::forge('root/footer');
				$pickup_html = '';
				// 記事一覧データ取得
				$list_query        = Model_Article_Basis::list_get($segment_info_get_array, 10);
				// 記事一覧HTML生成
				$article_list_html = Model_Article_Html::itype_list_html_create($list_query);
			}
		// sp_thumbnailデータセット
		$this->basic_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
			'sp_thumbnail_html' => '',
		));

		// コンテンツデータセット
		$this->basic_template->view_data["content"]->set('content_data', array(
			'recommend_html' => $recommend_article_html,
			'pickup_html'  => $pickup_html,
			'content_html' => $article_list_html,
		), false);

		// 人気記事HTML生成
		$article_access_1_res  = Model_Article_Basis::article_access_get(1,8);
		$article_access_7_res  = Model_Article_Basis::article_access_get(7,8);
		$article_access_30_res = Model_Article_Basis::article_access_get(30,8);














		$popular_html          = Model_Article_Html::article_popular_html_create($article_access_1_res, $article_access_7_res, $article_access_30_res, 'article');






		// シャッフル記事データ取得 
//		$shuffle_res = Model_Article_Basis::article_shuffle_get(0, 'article', 4);
		// シャッフル記事HTML生成
//		$shuffle_html = Model_Article_Html::article_shuffle_html_create($shuffle_res, 'article');
//		var_dump($shuffle_html);

		// シャッフル記事データ取得(シャッフルボタン)
		$shuffle_res = Model_Article_Basis::article_shuffle_get(0, 'article', 1);
		// シャッフルボタン記事link生成
		$shuffle_article_link = Model_Article_Html::article_shuffle_button_link_create($shuffle_res);
		// シャッフルボタン記事linkセット
		$this->basic_template->view_data["header"]->set('header_data', array(
			'shuffle_article_url' => $shuffle_article_link,
		), false);
		// サイドバーコンテンツセット
		$this->basic_template->view_data["sidebar"]->set('sidebar_data', array(
			'popular_html' => $popular_html,
			'related_html' => '',
			'shuffle_html' => '',
		),false);
	}
}

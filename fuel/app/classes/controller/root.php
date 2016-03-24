<?php
/*
* Rootコントローラー
*
* トップページとカテゴリをコントロール。
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

		// トップのみ
		if($segment_info_get_array["top_judgment"] == true) {
			$this->basic_template->view_data["meta"]         = View::forge('root/meta');
			$this->basic_template->view_data["external_css"] = View::forge('root/externalcss');
			$this->basic_template->view_data["script"]       = View::forge('root/script');
			// ピックアップデータ取得
			$pickup_res  = Model_Article_Basis::pickup_get(array(1833,1832,1820,1684,1447,1342,1436,1417,1378,1269));
			// flickityピックアップHTML生成
//			$pickup_html = Model_Article_Html::flickity_pickup_html_create($pickup_res);
			// flexsliderピックアップHTML生成
//			$pickup_html = Model_Article_Html::flexslider_pickup_html_create($pickup_res);
		}
			else {
				$pickup_html = '';
			}
		// sp_thumbnailデータセット
		$this->basic_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
			'sp_thumbnail_html' => '',
		));
		// 記事一覧データ取得
		$list_query        = Model_Article_Basis::list_get($segment_info_get_array, 30);
		// 記事一覧HTML生成
		$article_list_html = Model_Article_Html::itype_list_html_create($list_query);

		// コンテンツデータセット
		$this->basic_template->view_data["content"]->set('content_data', array(
			'pickup_html'  => $pickup_html,
			'content_html' => $article_list_html,
		), false);

		// 人気記事HTML生成
		$article_access_1_res  = Model_Article_Basis::article_access_get(1,10);
		$article_access_7_res  = Model_Article_Basis::article_access_get(7,10);
		$article_access_30_res = Model_Article_Basis::article_access_get(30,10);
		$popular_html       = Model_Article_Html::article_popular_html_create($article_access_1_res, $article_access_7_res, $article_access_30_res, 'article');

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

		// フッター変更
		$this->basic_template->view_data["footer"] = View::forge('root/footer');
	}
}

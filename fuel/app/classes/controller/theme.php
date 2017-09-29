<?php
/*
* テーマコントローラー
* 
* 
* 
* 
*/

class Controller_Theme extends Controller_Theme_Template {
	// ルーター
	public function router($method, $params) {
		// セグメント審査と軽い記事審査
		if($params[1] == null && preg_match('/^[0-9]+$/', $method, $method_array)) {
			$method = (int)$method;
			// テーマがあるかどうかを検査する
			$is_theme = Model_Info_Basis::is_theme($method);
			// テーマページング
			if($is_theme && $params[0]) {
				// 1の場合テーマトップページに遷移
				if($params[0] == '1') {
					header('location:'.HTTP.'theme/'.$method.'/'); exit;
				}
					else {
						// メタセット
						$this->theme_template->view_data['meta'] = View::forge('noindex/meta');
					}
				return $this->action_index($method, $params);
			}
				// テーマトップページ
				else {
					// テーマがある場合
					if($is_theme) {
						return $this->action_index($method);
					}
						// エラー
						else {
							return $this->action_404();
						}
				}
		}
			// エラー
			else {
				 return $this->action_404();
			}
	}
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	//----------
	//アクション
	//----------
	public function action_index($method, $params) {
		// テーマの名前取得
		$theme_name = Model_Theme_Basis::theme_name_get($method, 3600);

		// ページングメソッド&タイトルセット
		if($params[0]) { $paging_method = (int)$params[0]; $this->theme_template->view_data['title'] = $paging_method.'ページ目'.'｜'.'「'.$theme_name.'」の人気まとめ一覧'.'｜'.TITLE;} else { $paging_method = 1; $this->theme_template->view_data['title'] = '「'.$theme_name.'」の人気まとめ一覧'.'｜'.TITLE; }
		// テーマres取得
		$theme_res = Model_Theme_Basis::theme_res_get($method, 3600);
		// テーマ一覧HTML生成
		list($theme_list_html, $theme_article_data_array) = Model_Theme_Html::theme_list_html_create($theme_res, $paging_method, 3600);
		// テーマページングデータ取得
		$theme_paging_data_array = Model_Theme_Basis::theme_paging_data_get($theme_article_data_array, 10, $paging_method);
		// テーマページングHTML生成
		$paging_html = Model_Theme_Html::theme_paging_html_create($theme_res, $theme_paging_data_array);
		// テーマのまとめ数HTML生成
		$theme_count_html = Model_Theme_Html::theme_count_html_create($theme_paging_data_array, $theme_article_data_array, 3600);
		// 合体
		$theme_list_html = $theme_list_html.$paging_html;

		// シャッフル記事データ取得
		$shuffle_res = Model_Article_Basis::article_shuffle_get($method, 'article', 1);
		// シャッフルボタン記事link生成
		$shuffle_article_link = Model_Article_Html::article_shuffle_button_link_create($shuffle_res);
		// シャッフルボタン記事linkセット
		$this->theme_template->view_data["header"]->set('header_data', array(
			'shuffle_article_url' => $shuffle_article_link,
		), false);




		// テーマデータHTML生成
		$theme_data_html = Model_Theme_Html::theme_data_html_create($theme_res);
		// ーマのキュレーターランキングarray取得
		$theme_curator_ranking_array = Model_Theme_Basis::theme_curator_ranking_array_get($theme_res);
		// テーマのキュレーターランキングhtml生成
		$theme_curator_ranking_html = Model_Theme_Html::theme_curator_ranking_html_create($theme_curator_ranking_array);


		// 関連テーマarray取得
		$theme_relation_2_array = Model_Theme_Basis::theme_relation_array_get($theme_res);
//pre_var_dump($theme_relation_2_array);
		// 関連テーマHTML生成
		$theme_relation_html = Model_Theme_Html::theme_relation_html_create($theme_res, $theme_relation_2_array, 3600);

		// モバイル判別するPHPクラスライブラリを利用した機種判別
		$detect = Model_info_Basis::mobile_detect_create();
		// 実際に設定する場所
		if($detect->isMobile() | $detect->isTablet()) {
			$mobile_theme_curator_ranking_html = $theme_curator_ranking_html;
			$theme_curator_ranking_html        = '';
			$mobile_theme_relation_html        = $theme_relation_html;
			$theme_relation_html               = '';
		}
			else {

			}

		// サイドバーコンテンツセット
		$this->theme_template->view_data["sidebar"]->set('sidebar_data', array(
			'theme_data_html'            => $theme_data_html,
			'theme_curator_ranking_html' => $theme_curator_ranking_html,
			'theme_relation_html'        => $theme_relation_html,
		),false);

		// コンテンツセット
		$this->theme_template->view_data["content"]->set('content_data', array(
			'theme_count_html'                  => $theme_count_html,
			'content_html'                      => $theme_list_html,
			'mobile_theme_curator_ranking_html' => $mobile_theme_curator_ranking_html,
			'mobile_theme_relation_html'        => $mobile_theme_relation_html,
		), false);

		// アーカイブデータ取得
		list($first_article_res, $last_article_res) = Model_Archive_Basis::archive_first_last_data_get();
		// アーカイブHTML生成
		$archive_li_html = Model_Archive_Html::archive_list_html_create($first_article_res, $last_article_res);
		// アーカイブコンテンツセット
		$this->theme_template->view_data["footer"]->set('footer_data', array(
//			'archive_html' => $archive_li_html,
		), false);

	}
	//------------
	//エラーページ
	//------------
	public function action_404() {
//		var_dump($this);
		// 404ステータスにする
	$this->response_status                                      = 404;
	$this->active_request->response->status                     = 404;
	$this->active_request->controller_instance->response_status = 404;
		// 記事メタセット
		$this->theme_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => '<meta name="robots" content="noindex">',
		), false);

		// sp_thumbnailデータセット
		$this->theme_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
			'sp_thumbnail_html' => '',
		), false);

		// 記事コンテンツセット
		$this->theme_template->view_data["content"]->set('content_data', array(
			'content_html' => 'エラーページ<br><br><br><br><br><br><br><br><br>',
		), false);

		// サイドバーコンテンツセット
		$this->theme_template->view_data["sidebar"] = '';
		// スクリプトコンテンツセット
		$this->theme_template->view_data["script"] = '';

	}
}

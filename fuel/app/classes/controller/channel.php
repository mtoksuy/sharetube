<?php
/*
* Channelコントローラー
*
* ユーザーページをコントロール
*
*/
class Controller_Channel extends Controller_Channel_Template {
	// ルーター
	public function router($method, $params) {
		$params_chack = 0;
		$page_chack   = false;
		foreach($params as $key => $value) {
			$params_chack++;
		}
		// $paramsがある場合
		if($params) {
			if ($params_chack  === 1 && preg_match('/^[0-9]+?$/', $params[0], $params_array)) {
				$page       = (int)$params_array[0];
				$page_chack = true;
			}
		}
			// $paramsがない場合
			else {
				$page       = 0;
				$page_chack = true;
			}
		// セグメント審査と軽い審査
		if ($page_chack == true && preg_match('/^[a-zA-Z0-9_-]+$/', $method, $method_array)) {
			// Sharetubeユーザーか確認
			 $is_sharetube_id = Model_Info_Basis::is_sharetube_id($method);
			// 正しいユーザーの場合
			if($is_sharetube_id) {
				return $this->action_index($method, $page);
			}
				// エラー
				else {
					return $this->action_404();
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
	//--------------
	//基本アクション
	//--------------
	public function action_index($method, $page) {
//			var_dump($method, $page);
		// 追加タイトル(ページ)
		if($page) {
			$page_title = ' | '.$page.'ページ';
		}
			else {
			 $page_title = '';
			}
		// Sharetubeのユーザーデータ取得
		$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($method);
		// タイトルセット
		$this->channel_template->view_data["title"] = $sharetube_user_data_array["name"].'('.$method.')さんのチャンネル'.$page_title.' | '.TITLE;
//		var_dump($sharetube_user_data_array);
		// meta概要設定
		$meta_data = $sharetube_user_data_array["profile_contents"];
		$meta_html = Model_Channel_Html::channel_meta_create($meta_data);
		// 記事メタセット
		$this->channel_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => $meta_html,
		), false);






		// 記事一覧データ取得
		$list_query = Model_Channel_Basis::channel_article_list_get($method, 10, $page);
		// 記事一覧HTML生成
		$article_list_html = Model_Article_Html::itype_list_html_create($list_query);
		// ページングHTML生成
		$paging_html = Model_Channel_Html::paging_html_create($method, $page);

		// コンテンツデータセット
		$this->channel_template->view_data["content"]->set('content_data', array(
			'content_html' => $article_list_html,
			'paging_html'  => $paging_html,
		), false);

		// Sharetubeユーザーの書いた記事数を取得
		$article_count = Model_Info_Basis::sharetube_user_article_count_get($method);
		// profile_cardHTML生成
		$profile_card_html = Model_Channel_Html::profile_card_html_create($sharetube_user_data_array, $article_count);

		// サイドバーコンテンツセット
		$this->channel_template->view_data["sidebar"]->set('sidebar_data', array(
			'profile_card_html' => $profile_card_html,
		),false);


		// シャッフル記事データ取得
		$shuffle_res = Model_Article_Basis::article_shuffle_get(1, 'article', 1);
		// シャッフルボタン記事link生成
		$shuffle_article_link = Model_Article_Html::article_shuffle_button_link_create($shuffle_res);
		// シャッフルボタン記事linkセット
		$this->channel_template->view_data["header"]->set('header_data', array(
			'shuffle_article_url' => $shuffle_article_link,
		), false);

		// アーカイブデータ取得
		list($first_article_res, $last_article_res) = Model_Archive_Basis::archive_first_last_data_get();
		// アーカイブHTML生成
		$archive_li_html = Model_Archive_Html::archive_list_html_create($first_article_res, $last_article_res);
		// アーカイブコンテンツセット
		$this->channel_template->view_data["footer"]->set('footer_data', array(
			'archive_html' => $archive_li_html,
		), false);

	}
	//------------
	//エラーページ
	//------------
	public function action_404() {
		// 404ステータスにする
		$this->response_status                                      = 404;
		$this->active_request->response->status                     = 404;
		$this->active_request->controller_instance->response_status = 404;
		// 記事メタセット
		$this->channel_template->view_data["meta"] = View::forge('404/meta');

		// 記事コンテンツセット
		$this->channel_template->view_data["content"]->set('content_data', array(
			'content_html' => 'エラーページ<br><br><br><br><br><br><br><br><br>',
		), false);

		// サイドバーコンテンツセット
		$this->channel_template->view_data["sidebar"] = '';
		// スクリプトコンテンツセット
		$this->channel_template->view_data["script"] = '';
	}
}
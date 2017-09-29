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
/*
		pre_var_dump($method);
		pre_var_dump($params);
*/



/*
http://localhost/sharetube/channel/mosimo/
string(6) "mosimo"

array(0) {
}
http://localhost/sharetube/channel/mosimo/8/
string(6) "mosimo"

array(1) {
  [0]=>
  string(1) "8"
}
http://localhost/sharetube/channel/mosimo/recommendarticle/
string(6) "mosimo"

array(1) {
  [0]=>
  string(16) "recommendarticle"
}
http://localhost/sharetube/channel/mosimo/recommendarticle/8/
string(6) "mosimo"

array(2) {
  [0]=>
  string(16) "recommendarticle"
  [1]=>
  string(1) "8"
}

http://localhost/sharetube/channel/mosimo/famearticle/
http://localhost/sharetube/channel/mosimo/famearticle/8/

http://localhost/sharetube/channel/mosimo/like/
http://localhost/sharetube/channel/mosimo/like/8/
今ここ
もう全部書き換えたほうがいいかも
*/

//pre_var_dump('----------------------------------');


		$root_chack          = false;
		$function_chack      = false;
		$root_page_chack     = false;
		$function_page_chack = false;
		$error_chack         = false;
		$function_name       = '';
		$root_page           = 0;
		$function_page       = 0;

		// セグメント審査と軽い審査
		if(preg_match('/^[a-zA-Z0-9_-]+$/', $method, $method_array)) {
			// Sharetubeユーザーか確認
			 $is_sharetube_id = Model_Info_Basis::is_sharetube_id($method);
			 $root_chack = true;
		}
			else {
				$error_chack = true;
			}

		// 機能以上のディレクトリはエラー
		if($params[2] != NULL) {
			$error_chack = true;
		}

		// 機能別の場合
		if(preg_match('/recommendarticle|famearticle|like/', $params[0], $params_array_1)) {
			$function_chack = true;
			$function_name  = $params_array_1[0];
			// 機能別のページがある場合
			if(preg_match('/^[0-9]+?$/', $params[1], $params_array_2)) {
				$function_page_chack = true;
				$function_page       = (int)$params_array_2[0];
				// メタセット
				$this->channel_template->view_data['meta'] = View::forge('noindex/meta');
			}
				else if($params[1] != NULL) {
					$error_chack = true;
				}
		}
			// ページがある場合
			else if(preg_match('/^[0-9]+?$/', $params[0], $params_array_3)) {
				$root_page_chack = true;
				$root_page       = (int)$params_array_3[0];
				// メタセット
				$this->channel_template->view_data['meta'] = View::forge('noindex/meta');
				if($function_chack == false && $params[1]) {
					$error_chack = true;
				}
			}
				else if($params[0] != NULL) {
					$error_chack = true;
				}

/*************************************/
	if(!$error_chack) {
/*
		pre_var_dump('$root_chack：'.$root_chack);
		pre_var_dump('$root_page_chack：'.$root_page_chack);
		
		pre_var_dump('$function_chack：'.$function_chack);
		pre_var_dump('$function_page_chack：'.$function_page_chack);
		
		pre_var_dump('$function_name：'.$function_name);
		pre_var_dump('$function_page：'.$function_page);
*/
		if($function_chack) {
			return $this->action_function($method, $function_name, $function_page);
		}
			else {
				return $this->action_index($method, $root_page);
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
	public function action_index($method, $root_page) {
		// 0だった場合1にする
		if($root_page == 0) {$root_page = 1;}
		// 追加タイトル(ページ)
		if($root_page > 1) {
			$page_title = ' | '.$root_page.'ページ';
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
		$list_query = Model_Channel_Basis::channel_article_list_get($method, 10, $root_page);
		// 記事一覧HTML生成
		$article_list_html = Model_Article_Html::itype_list_html_create($list_query);
		// ページングHTML生成 古いページング
//		$paging_html = Model_Channel_Html::paging_html_create($method, $root_page);
		// まとめページングデータ取得
		$channel_article_paging_data_array = Model_Channel_Basis::channel_root_article_paging_data_get($method, 10, $root_page);
		// まとめページングHTML生成
		$paging_html                         = Model_Channel_Html::channel_article_paging_html_create($channel_article_paging_data_array, $method);
//		var_dump($paging_html);

		// Sharetubeユーザーの書いた記事数を取得
		$article_count = Model_Info_Basis::sharetube_user_article_count_get($method);
		// Sharetubeユーザーの書いた注目記事数を取得
		$recommend_article_count = Model_Info_Basis::sharetube_user_recommend_article_count_get($method);
		// Sharetubeユーザーの書いた殿堂記事数を取得
		$fame_article_count = Model_Info_Basis::sharetube_user_fame_article_count_get($method);
		// 合体
		$article_count_array = array('root' => $article_count, 'recommend' => $recommend_article_count, 'fame' => $fame_article_count);
		// チャンネルヘッダーHTML生成
		$channel_header_html = Model_Channel_Html::channel_header_html_create($method, $function_name, $article_count_array);

		// profile_cardHTML生成
		$profile_card_html = Model_Channel_Html::profile_card_html_create($sharetube_user_data_array, $article_count);

		// 参加しているテーマ一覧res取得
		$theme_relation_2_array = Model_Channel_Basis::sharetube_user_join_theme_res_get($method);
		// 参加しているテーマ一覧HTML生成
		$user_join_theme_html = Model_Theme_Html::theme_relation_html_create($theme_res, $theme_relation_2_array, 3600);
		$user_join_theme_html = preg_replace('/関連テーマ/', '参加しているテーマ', $user_join_theme_html);

		// モバイル判別するPHPクラスライブラリを利用した機種判別
		$detect = Model_info_Basis::mobile_detect_create();
		// 実際に設定する場所
		if($detect->isMobile() | $detect->isTablet()) {
			$mobile_user_join_theme_html = $user_join_theme_html;
			$user_join_theme_html        = '';
		}
			else {

			}

		// サイドバーコンテンツセット
		$this->channel_template->view_data["sidebar"]->set('sidebar_data', array(
			'profile_card_html' => $profile_card_html.$user_join_theme_html,
		),false);

		// コンテンツデータセット
		$this->channel_template->view_data["content"]->set('content_data', array(
			'channel_header_html'         => $channel_header_html,
			'content_html'                => $article_list_html,
			'paging_html'                 => $paging_html,
			'mobile_user_join_theme_html' => $mobile_user_join_theme_html,
		), false);











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
//			'archive_html' => $archive_li_html,
		), false);

	}
	//--------------
	//機能アクション
	//--------------
	public function action_function($method, $function_name, $function_page) {
		// 0だった場合1にする
		if($function_page == 0) {$function_page = 1;}
//			var_dump($method, $page);
		switch($function_name) {
			case 'recommendarticle':
				$function_name_title = '注目';
			break;
			case 'famearticle':
				$function_name_title = '殿堂';
			break;
			case 'like':
				$function_name_title = 'いいね';
			break;
		}
		// 機能別ディレクトリ
		$function_dir = $function_name;
		// URLから取得した機能の名前をリネーム
		$function_name = Model_Channel_Basis::channel_function_name_rename_get($function_name);

		// 追加タイトル(ページ)
		if($function_page > 1) {
			$page_title = ' | '.$function_page.'ページ';
		}
			else {
			 $page_title = '';
			}
		// Sharetubeのユーザーデータ取得
		$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($method);
		// タイトルセット
		$this->channel_template->view_data["title"] = $sharetube_user_data_array["name"].'('.$method.')さんのチャンネル | '.$function_name_title.''.$page_title.' | '.TITLE;
		// meta概要設定
		$meta_data = $sharetube_user_data_array["profile_contents"];
		$meta_html = Model_Channel_Html::channel_meta_create($meta_data);
		// 記事メタセット
		$this->channel_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => $meta_html,
		), false);

		// 機能別記事一覧データ取得
		$list_query = Model_Channel_Basis::channel_function_article_list_get($method, $function_name, 10, $function_page);
		//
//		if(!$list_query) { return $this->action_404();}



		// 記事一覧HTML生成
		$article_list_html = Model_Article_Html::itype_list_html_create($list_query);
		// ページングHTML生成 古いページング
//		$paging_html = Model_Channel_Html::paging_html_create($method, $function_page);

		// まとめページングデータ取得
		$channel_article_paging_data_array = Model_Channel_Basis::channel_function_article_paging_data_get($method, $function_name, 10, $function_page);
//		pre_var_dump($channel_article_paging_data_array);

		// まとめページングHTML生成
		$paging_html = Model_Channel_Html::channel_article_paging_html_create($channel_article_paging_data_array, $method, 'channel', $function_dir.'/');
//		var_dump($paging_html);

		// Sharetubeユーザーの書いた記事数を取得
		$article_count = Model_Info_Basis::sharetube_user_article_count_get($method);
		// Sharetubeユーザーの書いた注目記事数を取得
		$recommend_article_count = Model_Info_Basis::sharetube_user_recommend_article_count_get($method);
		// Sharetubeユーザーの書いた殿堂記事数を取得
		$fame_article_count = Model_Info_Basis::sharetube_user_fame_article_count_get($method);
		// 合体
		$article_count_array = array('root' => $article_count, 'recommend' => $recommend_article_count, 'fame' => $fame_article_count);

		// チャンネルヘッダーHTML生成
		$channel_header_html = Model_Channel_Html::channel_header_html_create($method, $function_dir, $article_count_array);

		// Sharetubeユーザーの書いた記事数を取得
		$article_count = Model_Info_Basis::sharetube_user_article_count_get($method);
		// profile_cardHTML生成
		$profile_card_html = Model_Channel_Html::profile_card_html_create($sharetube_user_data_array, $article_count);

		// 参加しているテーマ一覧res取得
		$theme_relation_2_array = Model_Channel_Basis::sharetube_user_join_theme_res_get($method);
		// 参加しているテーマ一覧HTML生成
		$user_join_theme_html = Model_Theme_Html::theme_relation_html_create($theme_res, $theme_relation_2_array, 3600);
		$user_join_theme_html = preg_replace('/関連テーマ/', '参加しているテーマ', $user_join_theme_html);

		// モバイル判別するPHPクラスライブラリを利用した機種判別
		$detect = Model_info_Basis::mobile_detect_create();
		// 実際に設置する場所の設定
		if($detect->isMobile() | $detect->isTablet()) {
			$mobile_user_join_theme_html = $user_join_theme_html;
			$user_join_theme_html = '';
		}
			else {

			}

		// サイドバーコンテンツセット
		$this->channel_template->view_data["sidebar"]->set('sidebar_data', array(
			'profile_card_html' => $profile_card_html.$user_join_theme_html,
		),false);

		// コンテンツデータセット
		$this->channel_template->view_data["content"]->set('content_data', array(
			'channel_header_html'         => $channel_header_html,
			'content_html'                => $article_list_html,
			'paging_html'                 => $paging_html,
			'mobile_user_join_theme_html' => $mobile_user_join_theme_html,
		), false);


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
//			'archive_html' => $archive_li_html,
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
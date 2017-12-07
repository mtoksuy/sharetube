<?php 
/**
 * ヘルプコントローラー
 * 
 * 
 * 
 * 
 */

class Controller_Help extends Controller_Help_Template {
	// ルーター
	public function router($method, $params) {
//var_dump($method);
		// セグメント審査
		if($method == 'index') {
			return $this->action_index();
		}
			// セグメント審査と軽い記事審査
			else if(!$params && preg_match('/^[0-9]+$/', $method, $method_array)) {
//var_dump($method);
				// あるぶんのヘルプを表示
				if((int)$method <= 22) {
					// ヘルプに遷移
					return $this->action_help($method);
				}
/*
			// 記事がある場合
			if($is_article) {
				return $this->action_index($method);
			}
				// エラー
				else {
					return $this->action_404($is_article_delete);
				}
*/
		}
			else if($method == 'ruleeeeeeeeeeeeeeeeeeeeeeeee') {
				return $this->action_rule();
			}
				// エラー
				else {
//					 return $this->action_404();
				}
	}
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	/////////////
	// アクション
	/////////////
	public function action_index() {
		// タイトルセット
		$this->help_template->view_data["title"] = 'Sharetubeヘルプセンター | '.TITLE;
		// html取得
		$help_html = View::forge('help/help');

		// コンテンツデータセット
		$this->help_template->view_data["content"]->set('content_data', array(
			'content_html' => $help_html,
		), false);
		// scriptデータセット
//		$this->help_template->view_data["script"] = View::forge('permalink/script');
	}
	////////////////////
	// アクション ヘルプ
	////////////////////
	public function action_help($method) {
		switch($method) {
			case 1:
				$method_title = 'Sharetubeはどんなサービスですか？';
			break;
			case 2:
				$method_title = 'Sharetubeアカウントとはなんですか？';
			break;
			case 3:
				$method_title = 'Sharetubeアカウントを取得するには？';
			break;
			case 4:
				$method_title = '登録の案内メールが届きません';
			break;
			case 5:
				$method_title = 'ログインできません';
			break;
			case 6:
				$method_title = 'パスワードを変更するには？';
			break;
			case 7:
				$method_title = 'パスワードを忘れてしまいました';
			break;
			case 8:
				$method_title = 'プロフィールを変更するには？';
			break;
			case 9:
				$method_title = 'Sharetubeアカウントを削除(退会)するには？';
			break;
			case 10:
				$method_title = 'Sharetubeまとめについて';
			break;
			case 11:
				$method_title = 'まとめとはなんですか？';
			break;
			case 12:
				$method_title = 'Sharetubeまとめを作成するには？';
			break;
			case 13:
				$method_title = 'やってはダメ！文章・画像を正しく引用する方法';
			break;
			case 14:
				$method_title = '人気が出るまとめを作成するには？';
			break;
			case 15:
				$method_title = 'インセンティブプログラムとは';
			break;
			case 16:
				$method_title = 'インセンティブを確認するには？';
			break;
			case 17:
				$method_title = 'Sharetubeアナリティクスの見方';
			break;
			case 18:
				$method_title = 'まとめインセンティブの受け取り方';
			break;
			case 19:
				$method_title = 'テーマとはなんですか？';
			break;
			case 20:
				$method_title = '新しいテーマを作ることはできますか？';
			break;
		}




		// タイトルセット
		$this->help_template->view_data["title"] = $method_title.'｜Sharetubeヘルプセンター | '.TITLE;

		// html取得
		$help_html = View::forge('help/'.$method.'');

		// コンテンツデータセット
		$this->help_template->view_data["content"]->set('content_data', array(
			'content_html' => $help_html,
		), false);

		// scriptデータセット
//		$this->help_template->view_data["script"] = View::forge('permalink/script');
	}

}
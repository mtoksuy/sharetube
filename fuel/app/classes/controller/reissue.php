<?php
/*
* パスワード再発行コントローラー
* 
* 
* 
* 
*/

class Controller_Reissue extends Controller_Reissue_Template {
	//--------
	//ルーター
	//--------
	public function router($method, $params) {
		// セグメント審査
		if($method == 'index') {
			return $this->action_index();
		}
			else if($method == 'rule') {
				return $this->action_rule();
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
	//----------------------
	//インデックスアクション
	//----------------------
	public function action_index() {
		$html = 
			'<div class="reissue">
				<div class="reissue_inner">

				</div>
			</div>';
		 // コンテンツセット
		$this->reissue_template->view_data['content']->set('content_data', array(
			'content_html' => $html,
		));
		 


/*
		// アーカイブコンテンツセット
		$this->rule_template->view_data["footer"]->set('footer_data', array(
			'archive_html' => $archive_li_html,
		), false);
*/



	}
	//--------------------
	//サブミットアクション
	//--------------------
	public function action_submit() {

/*

		$this->channel_template            = View::forge('basic/template');
		$this->channel_template->view_data = array(
			'title'        => TITLE,
			'meta'         => View::forge('basic/meta'),
			'external_css' => View::forge('reissue/externalcss'),
			'drawer'       => View::forge('basic/drawer'),
			'header'       => View::forge('basic/header'),
			'content'      => View::forge('basic/content'),
//			'sidebar'      => View::forge('basic/sidebar'),
			'footer'       => View::forge('basic/footer'),
			'script'       => View::forge('basic/script'),
		);

*/







	}
	//------------
	//エラーページ
	//------------
	public function action_404() {

	}
}
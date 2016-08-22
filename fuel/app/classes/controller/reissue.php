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
			else if($method == 'hash') {
				return $this->action_hash();
			}
				else if($method == 'complete') {
					return $this->action_complete();
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
		if($_POST) {
			// ポストの中身をエンティティ化する
			$post = Model_Security_Basis::post_security();
			// ハッシュ発行
			list($mail_address, $user_email_check, $user_check) = Model_Reissue_Basis::reissue_hash_issue($post);
		} // if($_POST) {
		// HTML呼び出し
		$reissue_html = View::forge('reissue/reissue');
		 // コンテンツセット
		$this->reissue_template->view_data['content']->set('content_data', array(
			'content_html' => $reissue_html,
		), false);
		// 制御変数セット
		$this->reissue_template->view_data["content"]->content_data["content_html"]->set('reissue_data', array(
			'post'             => $post,
			'user_email_check' => $user_email_check,
			'mail_address'     => $mail_address,
			'user_check'       => $user_check,
		));
	}
	//------------------
	//ハッシュアクション
	//------------------
	public function action_hash() {
		// ゲットの中身をエンティティ化する
		$get = Model_Security_Basis::get_security();
		$post = Model_Security_Basis::post_security();
		if($get) {
			// ハッシュでreissue_res取得
			$reissue_res = Model_Reissue_Basis::hash_is_reissue_res_get($get);
			// ハッシュでreissueアップデート
			list($reissue_check, $reissue_array) = Model_Reissue_Basis::hash_is_reissue_update($reissue_res);
	 		// 制御
	 		if($reissue_check) {
	 			if($reissue_array['change_check'] == 0) {
	 				// パスワード変更HTML生成
	 				$password_change_html = Model_Reissue_Html::password_change_html_create();
				}
					else {
	 					$password_change_html = '<p>すでにパスワードが変更されている発行です。</p>';
					}
			}
				else {
	 				$password_change_html = '<p>発行トークンが間違っています。</p>';
				}
		} //get
		if($post) {
			if($post['new_password'] === $post['new_password_confirm']) {
				// ユーザーのパスワードを変更
				$reissue_res = Model_Reissue_Basis::user_password_change($post);
				header('Location: '.HTTP.'reissue/complete/');
				exit;
			}
		}
		 // コンテンツセット
		$this->reissue_template->view_data['content']->set('content_data', array(
			'content_html' => $password_change_html,
		), false);
	}
	//------------------
	//コンプリートページ
	//------------------
	public function action_complete() {
		 // コンテンツセット
		$this->reissue_template->view_data['content']->set('content_data', array(
			'content_html' => '<p>パスワードを再設定完了いたしました。</p>',
		), false);
	}
	//------------
	//エラーページ
	//------------
	public function action_404() {

	}
}
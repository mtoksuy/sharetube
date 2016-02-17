<?php 
/**
 * 
 * エラーコントローラー
 * 
 * 存在しないURLを叩くとここに来るようにする。
 * 
 * 
 */
class Controller_Error extends Controller {
	// アクション
	public function action_404() {
		$error_html = View::forge('error/404');
		return $error_html;
	}
}
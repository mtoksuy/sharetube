<?php 
/**
 * サインアップテンプレート
 * 
 * 
 * 
 * 
 */

class Controller_Signup_Template extends Controller {
	// コントラスト
	public function __construct(\Request $request) {
		$this->request = $request;
	}
	// テンプレート
	public function before() {
		// validate_emailライブラリー読み込み
		require_once APPPATH.'classes/library/validateemail/basis.php';

		$this->signup_template            = View::forge('basic/template');
		$this->signup_template->view_data = array(
			'title'        => TITLE,
			'meta'         => View::forge('basic/meta'),
			'external_css' => View::forge('permalink/externalcss'),
			'drawer'       => View::forge('basic/drawer'),
			'header'       => View::forge('basic/header'),
			'mobile_ad'    => View::forge('basic/mobilead'),
			'sp_thumbnail' => View::forge('basic/spthumbnail'),
			'content'      => View::forge('basic/content'),
			'sidebar'      => '',
			'plus_add'     => '',
			'footer'       => View::forge('basic/footer'),
			'script'       => View::forge('permalink/script'),
		);
/*
		session_start();
		// ライブラリ読み込み
		require APPPATH.'classes/library/autoload.php';
		require APPPATH.'classes/library/security/basis.php';
		require APPPATH.'classes/library/dir/basis.php';
*/
	}
	// 最後に値を渡す
	public function after($response) {
		if($response === null) {
			$response = $this->signup_template;
		}
		return parent::after($response);
	}
}
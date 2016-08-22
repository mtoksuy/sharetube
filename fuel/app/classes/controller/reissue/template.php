<?php 
/**
 * コントローラーパスワード再発行テンプレート
 * 
 * パスワード再発行テンプレート
 * 
 * 
 */

class Controller_Reissue_Template extends Controller {
	// コントラスト
	public function __construct(\Request $request) {
		$this->request = $request;
	}
	// テンプレート
	public function before() {
		$this->reissue_template            = View::forge('basic/template');
		$this->reissue_template->view_data = array(
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
	}
	// 最後に値を渡す
	public function after($response) {
		if($response === null) {
			$response = $this->reissue_template;
		}
		return parent::after($response);
	}
}
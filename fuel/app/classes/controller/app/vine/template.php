<?php 
/**
 * コントローラーベーシックテンプレート
 * 
 * 汎用的なテンプレート
 * 
 * 
 */

class Controller_App_Vine_Template extends Controller {
	// コントラスト
	public function __construct(\Request $request) {
		$this->request = $request;
	}
	// テンプレート
	public function before() {
		$this->vine_template            = View::forge('app/template');
		$this->vine_template->view_data = array(
			'title'        => TITLE,
			'meta'         => View::forge('app/meta'),
			'external_css' => View::forge('app/vine/externalcss'),
			'drawer'       => '',
			'header'       => '',
			'content'      => View::forge('app/content'),
			'footer'       => View::forge('app/footer'),
			'script'       => View::forge('app/script'),
		);
	}
	// 最後に値を渡す
	public function after($response) {
		if($response === null) {
			$response = $this->vine_template;
		}
		return parent::after($response);
	}
}
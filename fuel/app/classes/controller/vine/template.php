<?php 
/**
 * コントローラーベーシックテンプレート
 * 
 * 汎用的なテンプレート
 * 
 * 
 */

class Controller_Vine_Template extends Controller {
	// コントラスト
	public function __construct(\Request $request) {
		$this->request = $request;
	}
	// テンプレート
	public function before() {
		$this->vine_template            = View::forge('basic/template');
		$this->vine_template->view_data = array(
			'title'        => TITLE,
			'meta'         => View::forge('article/meta'),
			'external_css' => View::forge('vine/externalcss'),
			'drawer'       => View::forge('vine/drawer'),
			'header'       => View::forge('vine/header'),
			'content'      => View::forge('basic/content'),
			'footer'       => View::forge('basic/footer'),
			'script'       => View::forge('article/script'),
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
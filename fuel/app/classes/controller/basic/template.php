<?php 
/**
 * コントローラーベーシックテンプレート
 * 
 * 汎用的なテンプレート
 * 
 * 
 */

class Controller_Basic_Template extends Controller {
	// コントラスト
	public function __construct(\Request $request) {
		$this->request = $request;
	}
	// テンプレート
	public function before() {
		$this->basic_template            = View::forge('basic/template');
		$this->basic_template->view_data = array(
			'title'        => TITLE,
			'meta'         => View::forge('basic/meta'),
			'external_css' => View::forge('basic/externalcss'),
			'drawer'       => View::forge('basic/drawer'),
			'header'       => View::forge('basic/header'),
			'mobile_ad'    => View::forge('basic/mobilead'),
			'sp_thumbnail' => View::forge('basic/spthumbnail'),
			'content'      => View::forge('basic/content'),
			'sidebar'      => View::forge('basic/sidebar'),
			'plus_add'     => '',
			'footer'       => View::forge('basic/footer'),
			'script'       => View::forge('basic/script'),
		);
	}
	// 最後に値を渡す
	public function after($response) {
		if($response === null) {
			$response = $this->basic_template;
		}
		return parent::after($response);
	}
}
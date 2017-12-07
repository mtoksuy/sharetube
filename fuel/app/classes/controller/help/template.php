<?php 
/**
 * ヘルプベーシックテンプレート
 * 
 * 汎用的なテンプレート
 * 
 * 
 */

class Controller_Help_Template extends Controller {
	// コントラスト
	public function __construct(\Request $request) {
		$this->request = $request;
	}
	// テンプレート
	public function before() {
		$this->help_template            = View::forge('help/template');
		$this->help_template->view_data = array(
			'title'        => TITLE,
			'meta'         => View::forge('basic/meta'),
			'external_css' => View::forge('basic/externalcss'),
			'drawer'       => View::forge('basic/drawer'),
			'header'       => View::forge('basic/header'),
			'mobile_ad'    => View::forge('basic/mobilead'),
			'sp_thumbnail' => View::forge('basic/spthumbnail'),
			'content'      => View::forge('basic/content'),
//			'sidebar'      => View::forge('basic/sidebar'),
			'plus_add'     => '',
			'footer'       => View::forge('basic/footer'),
//			'script'       => View::forge('help/script'),
		);
	}
	// 最後に値を渡す
	public function after($response) {
		if($response === null) {
			$response = $this->help_template;
		}
		return parent::after($response);
	}
}
<?php 
/**
 * コントローラーレイテーマテンプレート
 * 
 * 
 * 
 * 
 */

class Controller_Theme_Template extends Controller {
	// コントラスト
	public function __construct(\Request $request) {
		$this->request = $request;
	}
	// テンプレート
	public function before() {
		$this->theme_template            = View::forge('basic/template');
		$this->theme_template->view_data = array(
			'title'        => TITLE,
			'meta'         => View::forge('basic/meta'),
			'external_css' => View::forge('theme/externalcss'),
			'drawer'       => View::forge('basic/drawer'),
			'header'       => View::forge('basic/header'),
			'mobile_ad'    => View::forge('basic/mobilead'),
			'sp_thumbnail' => View::forge('basic/spthumbnail'),
			'content'      => View::forge('theme/content'),
			'sidebar'      => View::forge('theme/sidebar'),
			'footer'       => View::forge('basic/footer'),
			'script'       => View::forge('article/script'),
		);
	}
	// 最後に値を渡す
	public function after($response) {
		if($response === null) {
			$response = $this->theme_template;
		}
		return parent::after($response);
	}
}
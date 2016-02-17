<?php 
/**
 * コントローラーパーマリンクテンプレート
 * 
 * 汎用的なテンプレート
 * 
 * 
 */

class Controller_Permalink_Template extends Controller {
	// コントラスト
	public function __construct(\Request $request) {
		$this->request = $request;
	}
	// テンプレート
	public function before() {
		$this->permalink_template            = View::forge('basic/template');
		$this->permalink_template->view_data = array(
			'title'        => TITLE,
			'meta'         => View::forge('basic/meta'),
			'external_css' => View::forge('permalink/externalcss'),
			'drawer'       => View::forge('basic/drawer'),
			'header'       => View::forge('basic/header'),
			'mobile_ad'    => View::forge('basic/mobilead'),
			'sp_thumbnail' => View::forge('basic/spthumbnail'),
			'content'      => View::forge('basic/content'),
			'sidebar'      => View::forge('basic/sidebar'),
			'plus_add'     => '',
			'footer'       => View::forge('basic/footer'),
			'script'       => View::forge('permalink/script'),
		);
	}
	// 最後に値を渡す
	public function after($response) {
		if($response === null) {
			$response = $this->permalink_template;
		}
		return parent::after($response);
	}
}
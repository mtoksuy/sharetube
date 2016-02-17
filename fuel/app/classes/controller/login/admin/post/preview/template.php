<?php 
/**
 * コントローラープレビューテンプレート
 * 
 * プレビュー仕様
 * 
 * 
 */

class Controller_Login_Admin_Post_preview_Template extends Controller {
	// コントラスト
	public function __construct(\Request $request) {
		$this->request = $request;
	}
	// テンプレート
	public function before() {
		$this->article_template            = View::forge('basic/template');
		$this->article_template->view_data = array(
			'title'        => TITLE,
			'meta'         => View::forge('article/meta'),
			'external_css' => View::forge('article/externalcss'),
			'drawer'       => View::forge('basic/drawer'),
			'header'       => View::forge('basic/header'),
			'mobile_ad'    => View::forge('basic/mobilead'),
			'sp_thumbnail' => View::forge('basic/spthumbnail'),
			'content'      => View::forge('article/content'),
			'sidebar'      => View::forge('basic/sidebar'),
			'plus_add'     => View::forge('article/plusadd'),
			'footer'       => View::forge('basic/footer'),
			'script'       => View::forge('preview/script'),
		);
	}
	// 最後に値を渡す
	public function after($response) {
		if($response === null) {
			$response = $this->article_template;
		}
		return parent::after($response);
	}
}
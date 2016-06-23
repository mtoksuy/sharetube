<?php 
/**
 * コントローラー注目まとめテンプレート
 * 
 * 
 * 
 * 
 */

class Controller_Recommendarticle_Template extends Controller {
	// コントラスト
	public function __construct(\Request $request) {
		$this->request = $request;
	}
	// テンプレート
	public function before() {
		$this->recommendarticle_template            = View::forge('basic/template');
		$this->recommendarticle_template->view_data = array(
			'title'        => TITLE,
			'meta'         => View::forge('basic/meta'),
			'external_css' => View::forge('root/externalcss'),
			'drawer'       => View::forge('basic/drawer'),
			'header'       => View::forge('basic/header'),
			'mobile_ad'    => View::forge('basic/mobilead'),
			'sp_thumbnail' => View::forge('basic/spthumbnail'),
			'content'      => View::forge('basic/content'),
			'sidebar'      => View::forge('basic/sidebar'),
//			'plus_add'     => View::forge('basic/plusadd'),
			'footer'       => View::forge('basic/footer'),
			'script'       => View::forge('recommendarticle/script'),
		);
	}
	// 最後に値を渡す
	public function after($response) {
		if($response === null) {
			$response = $this->recommendarticle_template;
		}
		return parent::after($response);
	}
}
<?php 
/**
 * コントローラーチャンネルテンプレート
 * 
 * チャンネルテンプレート
 * 
 * 
 */

class Controller_Channel_Template extends Controller {
	// コントラスト
	public function __construct(\Request $request) {
		$this->request = $request;
	}
	// テンプレート
	public function before() {
		$this->channel_template            = View::forge('channel/template');
		$this->channel_template->view_data = array(
			'title'        => TITLE,
			'meta'         => View::forge('channel/meta'),
			'external_css' => View::forge('channel/externalcss'),
			'drawer'       => View::forge('basic/drawer'),
			'header'       => View::forge('basic/header'),
			'content'      => View::forge('channel/content'),
			'sidebar'      => View::forge('channel/sidebar'),
			'footer'       => View::forge('basic/footer'),
			'script'       => View::forge('article/script'),
		);
	}
	// 最後に値を渡す
	public function after($response) {
		if($response === null) {
			$response = $this->channel_template;
		}
		return parent::after($response);
	}
}
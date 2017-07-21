<?php 
/**
 * コントローラーテストテンプレート
 * 
 * 
 * 
 * 
 */

class Controller_Test_Template extends Controller {
	// コントラスト
	public function __construct(\Request $request) {
		$this->request = $request;
	}
	// テンプレート
	public function before() {
		$this->test_template            = View::forge('test/template');
		$this->test_template->view_data = array(
			'meta'         => View::forge('test/meta'),
		);
	}
	// 最後に値を渡す
	public function after($response) {
		if($response === null) {
			$response = $this->test_template;
		}
		return parent::after($response);
	}
}
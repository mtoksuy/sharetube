<?php 
/**
 * ログインテンプレート
 * 
 * 
 * 
 * 
 */

class Controller_Login_Template extends Controller {
	public $login_template;

	// コントラスト
	public function __construct(\Request $request) {
		$this->request = $request;
	}

	public function before() {
		session_start();
		// ライブラリ読み込み
		require APPPATH.'classes/library/autoload.php';
		require APPPATH.'classes/library/security/basis.php';
		require APPPATH.'classes/library/dir/basis.php';
	}

	// 最後に値を渡す
	public function after($response) {
		if($response === null) {
			$response = $this->login_template;
		}
		return parent::after($response);
	}
}
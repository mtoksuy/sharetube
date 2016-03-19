<?php 
/**
 * incentiveticketコントローラー
 * 
 * インセンティブチケットを表示する機能
 * 
 * 
 */

class Controller_Login_Admin_Incentiveticket extends Controller_Login_Template {
	// ルーター
	public function router($method, $params) {
		$params = (int)$params[0];
		$incentive_array_data = array();
		$incentive_array_data["method"] = $method;
		$incentive_array_data["params"] = $params;
//		var_dump($incentive_array_data);
		// 全体インセンティブ表示
		if($method == 'index') {
			return $this->action_index($incentive_array_data);
		}
			else if($method == 'complete') {
				return $this->action_index($incentive_array_data);				
			}
	}
	public function action_index($incentive_array_data) {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// viewテンプレート読み込み
			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => 'インセンティブチケット｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/incentiveticket/incentiveticket'),
			);
			if($incentive_array_data["method"] == 'index') {

			}
				else if($incentive_array_data["method"] == 'complete') {
					$ticket_primary_id = $incentive_array_data["params"];
					// 支払いチケットコンプリートした主旨をユーザーにメールで伝える
					Model_Mail_Basis::incentive_ticket_complete_mail($ticket_primary_id);
					// 支払いチケットコンプリート
					Model_Login_Incentive_Basis::incentive_ticket_complete($ticket_primary_id);

				}
			// インセンティブチケット全取得
			$incentive_paid_ticket_all_res = Model_Login_Incentive_Basis::incentive_paid_ticket_all_get();
			// インセンティブチケットリストHTML生成
			$incentive_ticket_list_html = Model_Login_Incentive_Html::incentive_ticket_list_html_create($incentive_paid_ticket_all_res);

			// コンテンツ挿入
			$this->login_admin_template->view_data["content"]->set('content_data',array(
				'incentive_ticket_list_html'  => $incentive_ticket_list_html,
			),false);
			return $this->login_admin_template;
		}
			// ログインしていない場合
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	} // action_index
}
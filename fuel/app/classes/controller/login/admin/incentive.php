<?php 
/**
 * incentiveコントローラー
 * 
 * インセンティブを表示する機能
 * 
 * 
 */

class Controller_Login_Admin_Incentive extends Controller_Login_Template {
	// ルーター
	public function router($method, $params) {
		$params = $params[0];
		$incentive_array_data = array();
		// 全体インセンティブ表示
		if($method == 'index') {
			return $this->action_index($incentive_array_data);
		}
			// インセンティブコンプリート表示
			else if($method == 'payrequest' && $params == 'complete') {
				return $this->action_complete($incentive_array_data);
			}
				// 報酬申請表示
				else if($method == 'payrequest') {
					return $this->action_payrequest($incentive_array_data);
				}
	}
	//--------------------
	//インセンティブトップ
	//--------------------
	public function action_index($incentive_array_data) {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// viewテンプレート読み込み
			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => 'インセンティブ｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/incentive/incentive'),
		);
		// Sharetubeのユーザーデータ取得
		$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($_SESSION["sharetube_id"], 0);

		// インセンティブのデータ取得
		$incentive_data_array      = Model_Login_Incentive_Basis::incentive_data_get();


		// インセンティブ報酬チケット取得取
		$incentive_paid_ticket_res = Model_Login_Incentive_Basis::incentive_paid_ticket_get($_SESSION["sharetube_id"]);
		// 報酬インセンティブチケットHTML生成
		$incentive_paid_ticket_html = Model_Login_Incentive_Html::incentive_paid_ticket_html_create($incentive_paid_ticket_res);

		// インセンティブHTML生成
		$incentive_html            = Model_Login_Incentive_Html::incentive_html_create($sharetube_user_data_array, $incentive_data_array, $incentive_paid_ticket_html);

		// 支払済みインセンティブレポート取得
		$incentive_paid_report_res = Model_Login_Incentive_Basis::incentive_paid_report_get($_SESSION["sharetube_id"]);
		// 支払済みレポートHTML生成
		$incentive_paid_html = Model_Login_Incentive_Html::incentive_paid_html_create($incentive_paid_report_res);


			// コンテンツ挿入
			$this->login_admin_template->view_data["content"]->set('content_data',array(
				'sharetube_user_data_array'  => $sharetube_user_data_array,
				'incentive_data_array'       => $incentive_data_array,
				'incentive_html'             => $incentive_html,
				'incentive_paid_html'        => $incentive_paid_html,
				'payrequest'                 => false,
				'complete'                   => false,
			),false);
			return $this->login_admin_template;
		}
			// ログインしていない場合
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	} // action_index
	//-----------------
	//action_payrequest
	//-----------------
	public static function action_payrequest($incentive_array_data) {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// viewテンプレート読み込み
			$login_admin_template            = View::forge('login/admin/template');
			$login_admin_template->view_data = array(
				'title'   => '報酬申請|インセンティブ｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/incentive/incentive'),
			);
		// Sharetubeのユーザーデータ取得
		$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($_SESSION["sharetube_id"], 0);
		// インセンティブのデータ取得
		$incentive_data_array      = Model_Login_Incentive_Basis::incentive_data_get();
		// 支払画面のHTML生成
		$incentive_payrequest_html = Model_Login_Incentive_Html::incentive_payrequest_html_create($sharetube_user_data_array, $incentive_data_array);
			// コンテンツ挿入
			$login_admin_template->view_data["content"]->set('content_data',array(
				'incentive_payrequest_html' => $incentive_payrequest_html,
				'sharetube_user_data_array' => $sharetube_user_data_array,
				'incentive_data_array'      => $incentive_data_array,
				'payrequest'                => true,
				'complete'                  => false,
			),false);
			return $login_admin_template;
		}
			// ログインしていない場合
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	} // action_payrequest
	//---------------
	//action_complete
	//---------------
	public static function action_complete($incentive_array_data) {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// viewテンプレート読み込み
			$login_admin_template            = View::forge('login/admin/template');
			$login_admin_template->view_data = array(
				'title'   => '申請完了|報酬申請|インセンティブ｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/incentive/incentive'),
			);
		// Sharetubeのユーザーデータ取得
		$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($_SESSION["sharetube_id"], 0);
		// インセンティブのデータ取得
		$incentive_data_array      = Model_Login_Incentive_Basis::incentive_data_get();
		// 支払いチェック
		$pay_money_int  = (int)($incentive_data_array["rate"]*$sharetube_user_data_array["pay_pv"]);
		$pay_check      = false;
		$bank_check     = false;
		$error_check    = false;
		// 3000円以上かどうか精査
		if($pay_money_int >= 3000) {
			$pay_check = true;
		}
			else {
				$pay_check = false;
			}

		// 銀行口座が登録されてあるか精査する
		if($sharetube_user_data_array["bank_name"] && $sharetube_user_data_array["account_holder"] && $sharetube_user_data_array["account_type"] && $sharetube_user_data_array["branch_code"] && $sharetube_user_data_array["account_number"]) {
			$bank_check = true;
		}
			else {
				$bank_check = false;
			}
		// コンプリート
		if($pay_check == true && $bank_check == true) {
			$error_check = true;
			// インセンティブ支払いチケット発行
			$incentive_ticket_number = Model_Login_Incentive_Basis::incentive_paid_ticket_issue($sharetube_user_data_array, $incentive_data_array);
			// インセンティブチケットが発行されたらユーザー側に送るメール
			Model_Mail_Basis::incentive_ticket_issuance_mail($sharetube_user_data_array, $incentive_data_array, $incentive_ticket_number);
			// メール
		}
			// エラー
			else {
				$error_check    = false;
			}
			// コンテンツ挿入
			$login_admin_template->view_data["content"]->set('content_data',array(
				'incentive_payrequest_html' => $incentive_payrequest_html,
				'sharetube_user_data_array' => $sharetube_user_data_array,
				'incentive_data_array'      => $incentive_data_array,
				'payrequest'                => false,
				'complete'                  => true,
				'error_check'               => $error_check,
			),false);
			return $login_admin_template;
		}
			// ログインしていない場合
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	} // action_complete
}
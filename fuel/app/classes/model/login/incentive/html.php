<?php 
class Model_Login_Incentive_Html extends Model {
	//----------------------
	//インセンティブHTML生成
	//----------------------
	public static function incentive_html_create($sharetube_user_data_array, $incentive_data_array, $incentive_paid_ticket_html) {
		// 確定金額取得
		$confirm_money  = (int)($sharetube_user_data_array["pay_pv"]*$incentive_data_array["rate"]);
		 $confirm_money = number_format($confirm_money);

		// インセンティブHTML生成
		$incentive_html = '<h1>インセンティブ</h1>
	<!-- incentive_data -->
 	<div class="incentive_data">
	 	<div class="incentive_data_content clearfix">
		 	<ul class="incentive_data_content_ul">
			 	<li class="incentive_data_content_ul_title">確定額</li>
			 	<li class="incentive_data_content_ul_number">'.$confirm_money.'円</li>
			</ul>
		 	<ul class="incentive_data_content_ul">
			 	<li class="incentive_data_content_ul_title">未払いPV数</li>
			 	<li class="incentive_data_content_ul_number">'.number_format($sharetube_user_data_array["pay_pv"]).' view</li>
			</ul>
		 	<ul class="incentive_data_content_ul">
		 		<div class="incentive_data_content_ul_payment">
		 			<a href="'.HTTP.'login/admin/incentive/payrequest/">報酬申請</a>
		 			<span>※ 支払下限額は3,000円です</span>
				</div>
			</ul>
		</div>
	</div> <!-- incentive_data -->

	<!-- incentive_data_report -->
 	<div class="incentive_data_report">
		<div class="incentive_data_report_title">
			<h2>インセンティブレポート</h2>
		</div>
			'.$incentive_paid_ticket_html.'
	 	<div class="incentive_data_report_content clearfix">
		 	<div class="incentive_data_report_content_summary">
		 		<h3>サマリー</h3>
				<table class="incentive_table_1">
					<thead>
						<tr>
							<th> </th>
							<th>確定金額</th>
							<th>未払いPV</th>
						</tr>
					</thead>
					<tbody>
						<tr>
						<th style="font-weight: normal;">一般まとめ</th>
							<td>'.$confirm_money.'円</td>
							<td>'.number_format($sharetube_user_data_array["pay_pv"]).' view</td>
						</tr>
						<tr class="total">
							<td>合計</td>
							<td>'.$confirm_money.'円</td>
							<td>'.number_format($sharetube_user_data_array["pay_pv"]).' view</td>
						</tr>
					</tbody>
				</table>
			</div><!-- incentive_data_report_content_summary -->';
		return $incentive_html;
	}
	//------------------------
	//支払済みレポートHTML生成
	//------------------------
	public static function incentive_paid_html_create($incentive_paid_report_res) {
		$paid_check          = false;
		$tr_lhtm             = '';
		$total_paid_money    = 0;
		$incentive_paid_html = '';
		foreach($incentive_paid_report_res as $key => $value) {
			$paid_check = true;
			$paid_time = date('Y年m月d日' ,strtotime($value["create_time"]));
			$total_paid_money = (int)$total_paid_money+(int)$value["paid_money"];

		 $tr_lhtm.='<tr>
			<th style="font-weight: normal;">'.$paid_time.'</th>
			<td>'.number_format($value["paid_money"]).'円</td>
		</tr>';
		}
		if($paid_check) {
			// 支払済みインセンティブHTML生成
		 	$incentive_paid_html = '<div class="incentive_data_report_content_paid">
				<h3>支払済インセンティブレポート</h3>
				<table class="incentive_table_1">
					<thead>
						<tr>
							<th> </th>
							<th style="border-right: 0 solid #d7d7d7;">支払い金額</th>
						</tr>
					</thead>
					<tbody>
						'.$tr_lhtm.'
					<tr class="total">
						<td>合計</td>
						<td>'.number_format($total_paid_money).'円</td>
					</tr>
					</tbody>
				</table>
			</div>';
		}
			else {

			}
		return $incentive_paid_html;
	}
	//----------------------------------
	//報酬インセンティブチケットHTML生成
	//----------------------------------
	public static function incentive_paid_ticket_html_create($incentive_paid_ticket_res) {
		$paid_check          = false;
		$tr_lhtm             = '';
		$total_paid_money    = 0;
		$incentive_paid_html = '';
		foreach($incentive_paid_ticket_res as $key => $value) {
			$paid_check = true;
			$paid_time = date('Y年m月d日' ,strtotime($value["create_time"]));
			$total_paid_money = (int)$total_paid_money+(int)$value["pay_money"];

		 $tr_lhtm.='<tr>
			<th style="font-weight: normal;">発行：'.$paid_time.'</th>
			<td>'.number_format($value["pay_money"]).'円</td>
		</tr>';
		}
		if($paid_check) {
			// 報酬インセンティブチケットHTML生成
		 	$incentive_paid_ticket_html = '<div class="incentive_data_report_content_paid">
				<h3>報酬インセンティブチケット</h3>
				<table class="incentive_table_1">
					<thead>
						<tr>
							<th> </th>
							<th style="border-right: 0 solid #d7d7d7;">報酬金額</th>
						</tr>
					</thead>
					<tbody>
						'.$tr_lhtm.'
					<tr class="total">
						<td>合計</td>
						<td>'.number_format($total_paid_money).'円</td>
					</tr>
					</tbody>
				</table>
			</div>';
		}
			else {

			}
		return $incentive_paid_ticket_html;
	}
	//------------------
	//支払画面のHTML生成
	//------------------
	public static function incentive_payrequest_html_create($sharetube_user_data_array, $incentive_data_array) {
		$pay_money_int  = (int)($sharetube_user_data_array["pay_pv"]*$incentive_data_array["rate"]);
		$pay_money      = number_format($pay_money_int);
		$pay_check      = false;
		$bank_check     = false;
		$error_check    = false;
		$pay_message    = '';
		$bank_message   = '';
		$error_css      = '';
		$incentive_href = ' href="'.HTTP.'login/admin/incentive/payrequest/complete/"';

		// 3000円以上かどうか精査
		if($pay_money_int >= 3000) {
			$pay_check = true;
		}
			else {
				$pay_check = false;
				$pay_message = '<p class="m_0">・インセンティブが3,000円に達していません</p>';
			}

		// 銀行口座が登録されてあるか精査する
		if($sharetube_user_data_array["bank_name"] && $sharetube_user_data_array["account_holder"] && $sharetube_user_data_array["account_type"] && $sharetube_user_data_array["branch_code"] && $sharetube_user_data_array["account_number"]) {
			$bank_check = true;
		}
			else {
				$bank_check = false;
				$bank_message  = '<p class="m_0">・振り込み先情報が登録されていません</p>';
			}
		if($pay_check == true && $bank_check == true) {
			$error_check = true;
		}
			else {
				$error_check    = false;
				$error_css      = ' error';
				$incentive_href = '';
				// エラーメッセージHTML生成
				$incentive_payrequest_error_html = '
					<div class="incentive_payrequest_error">
						'.$pay_message.'
						'.$bank_message.'
					</div>';
			}
		$incentive_payrequest_html = '
		  <h1>インセンティブ 報酬申請</h1>
			<!-- incentive_data -->
		 	<div class="incentive_data">
			 	<div class="incentive_data_content clearfix">
				 	<ul class="incentive_data_content_ul">
					 	<li class="incentive_data_content_ul_title">支払い可能額</li>
					 	<li class="incentive_data_content_ul_number">'.$pay_money.'円</li>
					</ul>
					<ul class="incentive_data_content_ul">
							<div class="incentive_data_content_ul_payment'.$error_css.'">
								<a style="width: 202px;"'.$incentive_href.'>インセンティブを受け取る</a>
								<span>※ 2営業日以内に振り込まれます。</span>
						</div>
					</ul>
				</div>
			</div> <!-- incentive_data -->
			'.$incentive_payrequest_error_html.'
			';
		return $incentive_payrequest_html;
	}
	//------------------------------------
	//インセンティブチケットリストHTML生成
	//------------------------------------
	public static function incentive_ticket_list_html_create($incentive_paid_ticket_all_res) {
		$li_list_html = '';
		foreach($incentive_paid_ticket_all_res as $key => $value) {
			// 金額をintにする
			$pay_money_int  = (int)($value["pay_money"]);
			// Sharetubeのユーザーデータ取得
			$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($value["sharetube_id"]);
			$li_list_html .= '<li>
				<p>発行日：'.$value["create_time"].'</p>
				<p>Sharetube_id：'.$value["sharetube_id"].'</p>
				<p>振り込み金額：'.number_format($pay_money_int).'円</p>
				<p>銀行名：'.$sharetube_user_data_array["bank_name"].'</p>
				<p>口座名義人：'.$sharetube_user_data_array["account_holder"].'</p>
				<p>口座の種類：'.$sharetube_user_data_array["account_type"].'</p>
				<p>支店コード：'.$sharetube_user_data_array["branch_code"].'</p>
				<p>口座番号：'.$sharetube_user_data_array["account_number"].'</p>
				<p>PV数：'.$value["pay_pv"].' view</p>
				<p>rate：'.$value["rate"].'</p>
				<p>連絡先：'.$sharetube_user_data_array["email"].'</p>
				<p>チャンネルページ：<a target="_blank" href="'.HTTP.'channel/'.$sharetube_user_data_array["sharetube_id"].'/">'.$sharetube_user_data_array["sharetube_id"].'さんのページ'.'</a></p>
				<div class="incentive_ticket_complete">
					<a href="'.HTTP.'login/admin/incentiveticket/complete/'.$value["primary_id"].'">完了</a>
				</div>
			</li>';
		}
		$incentive_ticket_list_html = '<div class="incentive_ticket_list">
			<div class="incentive_ticket_list_content">
				<ul>
					'.$li_list_html.'
				</ul>		
			</div>
		</div>';
		return $incentive_ticket_list_html;
	}


}

<?php 
class Model_Mail_Basis extends Model {
	//------------------------------
	//QBメール送信(全てはここに通す)
	//------------------------------
	public static function qbmail_send($post_array) {
		// エラー表示設定(qbmail仕様上エラー非表示にする)
		error_reporting(0);
		ini_set('display_errors', 1);
		// qdmail呼び出し
		require_once PATH."assets/library/qdmail/qdmail.php";
		require_once PATH."assets/library/qdmail/qdsmtp.php";

//			$mail = & new Qdmail(); ??
			$mail = new Qdmail();

//			pre_var_dump($mail);
//exit;
			$mail->smtp(true);

			// param設定
			$mail -> smtpServer($post_array["param"]);
			// 送信先
			$mail ->to($post_array["to"]);
			// 題名
			$mail ->subject($post_array["subject"]);
			// 送信元情報
			$mail ->from($post_array["from"]);
			// 本文挿入
			$mail ->text($post_array["message"]);
//			$mail ->html($post_array["message"]);
			// 自動テキスト生成機能はOFF
			$mail -> autoBoth(false);

			// 送信
			$return_flag = $mail ->send();
	}
	//-----------------------------------------------------
	//メール配信許可があるsharetubeユーザー全員へメール送信
	//-----------------------------------------------------
	public static function mail_delivery_ok_sharetube_id_uses_mail_send($post, $mail_delivery_ok_sharetube_id_uses_data_res) {
		$mail_message = $post['mail_message'];
		$bottom_fixed_phrase = "

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube [伝えたい情報をシェアする]キュレーションプラットフォームサービス
発行：Sharetube[シェアチューブ]サポートチーム
http://sharetube.jp/

お問合せ: http://sharetube.jp/contact/
COPYRIGHT(C) Sharetube ALL RIGHTS RESERVED.";
		// 合体
		$message = $mail_message.$bottom_fixed_phrase;
		// デコード
		$message = htmlspecialchars_decode($message);
/*
/ ヘッダー情報
$headers = '';
$headers .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '"' . "\r\n";
$headers .= 'Content-Transfer-Encoding: binary' . "\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$headers .= "From: " . mb_encode_mimeheader($mail_from_name) . "<" . $mail_from . ">" . "\r\n";
// 送信者名を指定しない場合は次のよう
*/
//		pre_var_dump($message);
		foreach($mail_delivery_ok_sharetube_id_uses_data_res as $key => $value) {
			$post_array = array(
				'from'    => 'Sharetube <info@sharetube.jp>',
				'to'      => $value['email'],
//				'subject' => '良いキュレーターになるためのSharetubeマガジン Vol.1',
				'subject' => $post['mail_title'],
				'message' => $message,
				'param'   => array(
					'host'     => 'localhost',
					'port'     => 25,
					'from'     => 'info@sharetube.jp', 
					'protocol' => 'SMTP',
					'user'     => '',
					'pass'     => '',),
			);
//			pre_var_dump($post_array);
			// qbメール送信
			Model_Mail_Basis::qbmail_send($post_array);
		}
	}
	//--------------------------------------------------
	//ユーザーがログインしたらお知らせのメールを送信する
	//--------------------------------------------------
	public static function login_account_report_mail($post) {
//	var_dump($post);

		// time関連取得
		$now_time = time();
		$now_date = date('Y-m-d H:i:s', $now_time);
		$message = ("ユーザーがログインしました
---------------------
[ログイン情報]

sharetube_id：{$post['sharetube_id']}
ログインした時間：".$now_date."

---------------------

Sharetube
http://sharetube.jp/

ログインページ
http://sharetube.jp/login/

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube [伝えたい情報をシェアする]キュレーションプラットフォームサービス
発行：Sharetube[シェアチューブ]サポートチーム
http://sharetube.jp/

お問合せ: http://sharetube.jp/contact/
COPYRIGHT(C) Sharetube ALL RIGHTS RESERVED.");
		$post_array = array(
			'from'    => 'system_report@sharetube.jp',
			'to'      => 'system_report@sharetube.jp',
			'subject' => 'Sharetubeのユーザーがログインしました',
			'message' => $message,
			'param'   => array(
				'host'     => 'localhost',
				'port'     => 25,
				'from'     => 'system_report@sharetube.jp', 
				'protocol' => 'SMTP',
				'user'     => '',
				'pass'     => '',),
		);
			// qbメール送信
			Model_Mail_Basis::qbmail_send($post_array);
	}
	//--------------------------------------
	//新規アカウントがいたら報告メールがくる
	//--------------------------------------
	public static function new_account_report_mail($post) {
		$message = ("新規登録がありました
---------------------
[登録情報]

sharetube_id: {$post['sharetube_id']}
パスワード: {$password_hidden_string}
---------------------

Sharetube
http://sharetube.jp/

ログインページ
http://sharetube.jp/login/

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube [伝えたい情報をシェアする]キュレーションプラットフォームサービス
発行：Sharetube[シェアチューブ]サポートチーム
http://sharetube.jp/

お問合せ: http://sharetube.jp/contact/
COPYRIGHT(C) Sharetube ALL RIGHTS RESERVED.");
		$post_array = array(
			'from'    => 'system_report@sharetube.jp',
			'to'      => 'system_report@sharetube.jp',
			'subject' => 'Sharetubeへ新規登録者がいます',
			'message' => $message,
			'param'   => array(
				'host'     => 'localhost',
				'port'     => 25,
				'from'     => 'system_report@sharetube.jp', 
				'protocol' => 'SMTP',
				'user'     => '',
				'pass'     => '',),
		);
			// qbメール送信
			Model_Mail_Basis::qbmail_send($post_array);
	}
	//------------------------------------
	//新規アカウント登録者へ自動メール送信
	//------------------------------------
	public static function new_account_contact_mail($post, $password_hidden_string) {
		$message = ("Sharetubeへご登録ありがとうございます。

あなたの専門分野・好き・興味のある伝えたい情報をまとめよう

---------------------
[登録情報]

sharetube_id: {$post['sharetube_id']}
パスワード: {$password_hidden_string}
---------------------

Sharetube
http://sharetube.jp/

ログインページ
http://sharetube.jp/login/

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube [伝えたい情報をシェアする]キュレーションプラットフォームサービス
発行：Sharetube[シェアチューブ]サポートチーム
http://sharetube.jp/

お問合せ: http://sharetube.jp/contact/
COPYRIGHT(C) Sharetube ALL RIGHTS RESERVED.");
		$post_array = array(
			'from'    => 'Sharetube <info@sharetube.jp>',
			'to'      => ''.$post["email"].'',
			'subject' => ''.$post['sharetube_id'].'さん Sharetubeへようこそ',
			'message' => $message,
			'param'   => array(
				'host'     => 'localhost',
				'port'     => 25,
				'from'     => 'info@sharetube.jp', 
				'protocol' => 'SMTP',
				'user'     => '',
				'pass'     => '',),
		);
			// qbメール送信
			Model_Mail_Basis::qbmail_send($post_array);
	}
	//------------------
	//qbmailでメール送信
	//------------------
	public static function qbmail_post($post) {
		$message = ("お問い合わせからフォーム送信されました。
		お名前:{$post['name']}
		メールアドレス:{$post['email']}
		件名:{$post['web']}
		---------------------------------
		メッセージ:{$post['text_area']}");

		$post_array = array(
			'from'    => 'info@sharetube.jp',
			'to'      => 'info@sharetube.jp',
			'subject' => 'Sharetubeのフォーム通知',
			'message' => $message,
			'param'   => array(
				'host'     => 'localhost',
				'port'     => 25,
				'from'     => 'info@sharetube.jp', 
				'protocol' => 'SMTP',
				'user'     => '',
				'pass'     => '',),
		);
			// qbメール送信
			Model_Mail_Basis::qbmail_send($post_array);
	}
	//----------------------------------------------------------
	//インセンティブチケットが発行されたらユーザー側に送るメール
	//----------------------------------------------------------
	public static function incentive_ticket_issuance_mail($sharetube_user_data_array, $incentive_data_array, $incentive_ticket_number) {
		// 振込金額
		$pay_money_int  = (int)($incentive_data_array["rate"]*$sharetube_user_data_array["pay_pv"]);
		$pay_money      = number_format($pay_money_int);

		// time関連取得
		$now_time = time();
		$now_date = date('Y年m月d日', $now_time);
		$now_2day_date = date('Y年m月d日', $now_time+(86400*4));

		$message = ("Sharetubeをご利用くださいましてありがとうございます。

インセンティブチケットが発行されましたので
レポートを送りいたします。


[インセンティブチケット発行レポート]
Sharetube_id：".$sharetube_user_data_array['sharetube_id']."

チケット_id：".$incentive_ticket_number."

振込予定日：".$now_date."〜".$now_2day_date."

支払額：".$pay_money."円
------------------------

口座情報はメールにてセキュリティーの観点から記述できません。
トラブルを無くすためSharetubeにログインして口座情報をお確かめください。
また、振込予定日を過ぎても振込が無い場合はお手数かけますが、お問い合わせよりご連絡ください。

では、引き続きよろしくお願いいたします。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube [伝えたい情報をシェアする]キュレーションプラットフォームサービス
発行：Sharetube[シェアチューブ]サポートチーム
http://sharetube.jp/

お問合せ: http://sharetube.jp/contact/
COPYRIGHT(C) Sharetube ALL RIGHTS RESERVED.");
		$post_array = array(
			'from'    => 'Sharetube <info@sharetube.jp>',
			'to'      => $sharetube_user_data_array['email'],
			'subject' => 'Sharetube[インセンティブチケットが発行されました]',
			'message' => $message,
			'param'   => array(
				'host'     => 'localhost',
				'port'     => 25,
				'from'     => 'info@sharetube.jp', 
				'protocol' => 'SMTP',
				'user'     => '',
				'pass'     => '',),
		);
			// qbメール送信
			Model_Mail_Basis::qbmail_send($post_array);
	}
	//-------------------------------------------------------------
	// 支払いチケットコンプリートした主旨をユーザーにメールで伝える
	//-------------------------------------------------------------
	public static function incentive_ticket_complete_mail($ticket_primary_id) {
		// チケット情報取得
		$ticket_primary_id_res = DB::query("
			SELECT *
			FROM incentive_paid_ticket
			WHERE primary_id = ".$ticket_primary_id."")->execute();
		foreach($ticket_primary_id_res as $key => $value) {
			$ticket_complete_array['sharetube_id'] = $value['sharetube_id'];
			$ticket_complete_array['pay_money']    = $value['pay_money'];
			$ticket_complete_array['pay_pv']       = $value['pay_pv'];
			$ticket_complete_array['rate']         = $value['rate'];
			$ticket_complete_array['create_time']  = $value['create_time'];
		}
		// Sharetubeのユーザーデータ取得
		$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($ticket_complete_array['sharetube_id']);
		// 振込金額
		$pay_money_int  = (int)$ticket_complete_array['pay_money'];
		$pay_money      = number_format($pay_money_int);

		$message = ("Sharetubeをご利用くださいましてありがとうございます。

インセンティブの支払いが完了いたしました。
ご確認よろしくお願い致します。

[インセンティブ支払いレポート]
Sharetube_id：".$sharetube_user_data_array['sharetube_id']."

チケット_id：".$ticket_primary_id."

支払額：".$pay_money."円
------------------------


では、引き続きよろしくお願いいたします。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube [伝えたい情報をシェアする]キュレーションプラットフォームサービス
発行：Sharetube[シェアチューブ]サポートチーム
http://sharetube.jp/

お問合せ: http://sharetube.jp/contact/
COPYRIGHT(C) Sharetube ALL RIGHTS RESERVED.");
		$post_array = array(
			'from'    => 'Sharetube <info@sharetube.jp>',
			'to'      => $sharetube_user_data_array['email'],
			'subject' => 'Sharetube[インセンティブを振り込みました]',
			'message' => $message,
			'param'   => array(
				'host'     => 'localhost',
				'port'     => 25,
				'from'     => 'info@sharetube.jp', 
				'protocol' => 'SMTP',
				'user'     => '',
				'pass'     => '',),
		);
			// qbメール送信
			Model_Mail_Basis::qbmail_send($post_array);
	}
	//---------------------------------------------------
	// 再パスワード発行の手順と本人確認のためにメール送信
	//---------------------------------------------------
	public static function reissue_authentic_check_mail($mail_address, $hash) {


		$message = ("Sharetubeをご利用くださいましてありがとうございます。
パスワード再設定の発行が行われました。
ご確認よろしくお願い致します。

[本人確認&パスワード再設定ページ]
".HTTP."reissue/hash/?hash=".$hash."&trash=trash

なお、パスワード再発行を行っていないにもかかわらず
このメールが届いた方はお手数かけますが
Sharetubeのお問い合わせからご連絡くださいますようよろしくお願い致します。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube [伝えたい情報をシェアする]キュレーションプラットフォームサービス
発行：Sharetube[シェアチューブ]サポートチーム
http://sharetube.jp/

お問合せ: http://sharetube.jp/contact/
COPYRIGHT(C) Sharetube ALL RIGHTS RESERVED.");
		$post_array = array(
			'from'    => 'Sharetube <info@sharetube.jp>',
			'to'      => $mail_address,
			'subject' => 'Sharetube[パスワード再設定の発行が行われました]',
			'message' => $message,
			'param'   => array(
				'host'     => 'localhost',
				'port'     => 25,
				'from'     => 'info@sharetube.jp', 
				'protocol' => 'SMTP',
				'user'     => '',
				'pass'     => '',),
		);
			// qbメール送信
			Model_Mail_Basis::qbmail_send($post_array);
	}
























		//--------------------------------------------------------------------------
		//コンタクトformメール送信(PEARを利用した関数。一応サンプルとして残しておく)
		//--------------------------------------------------------------------------
		function contact_post($post) {
			$mail = 'info@programmerbox.com';
			// mb_encode_mimeheader用エンコードの設定
			mb_language("japanese");
			mb_internal_encoding("UTF-8");
			require_once 'Mail.php';
			require_once 'Mail/mime.php';
			// ① Mail_Mimeクラスのインスタンス化
			$mime = new Mail_Mime("\n");
			// ② テキスト本文の設定
			$mime->setTxtBody("CONTACTからフォーム送信されました。
お名前:{$post['name']}
メールアドレス:{$post['email']}
web:{$post['web']}
---------------------------------
メッセージ:{$post['text_area']}");
			// ③ 添付ファイルの指定
//			$mime->addAttachment("nagoya.jpg", "image/jpg");

			// ④ メッセージの設定
			$bodyParam = array(
			"head_charset"  => "ISO-2022-JP",
			"text_encoding" => "ISO-2022-JP",
			"text_charset"  => "UTF-8"
			);
			// ⑤ メッセージを構築する
			$body = $mime->get($bodyParam);

			$addHeaders = array(
			'From'    => 'info@programmerbox.com',                            //送信元
			'To'      =>  'info@programmerbox.com',                           //送信宛
			'Subject' =>  mb_encode_mimeheader("Programmerboxのフォーム通知") //タイトル
			);
			// ⑥ ヘッダ行を構築する
			$headers = $mime->headers($addHeaders);

			// 送信元smtp設定
			$params = array(
			'host'     => 'smtp.souya-matsuoka.net',
			'port'     => 587,
			'auth'     => true,
			'username' => 'info@programmerbox.com',
			'password' => 'matu1012'
			);
			$recipients =  $mail;
			$smtp = Mail::factory( 'smtp', $params);
//			var_dump($smtp);
			$e = $smtp->send( $recipients, $headers, $body);
			if ( PEAR::isError($e) )
			{
				print( $e->getMessage() );
			}
				else
				{
//					print( "<h2>詳細を{$recipients}様宛にメールを送りました。</h2>" );
				}
				return $event_date;
		} // function contact_post($post)
}
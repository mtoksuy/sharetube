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

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube - シェアしたくなるコンテンツが集まる、集まる。
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

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube - シェアしたくなるコンテンツが集まる、集まる。
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

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube - シェアしたくなるコンテンツが集まる、集まる。
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

sharetube_id：{$post['sharetube_id']}
パスワード：{$password_hidden_string}
---------------------

Sharetube
http://sharetube.jp/

ログインページ
http://sharetube.jp/login/

利用規約
http://sharetube.jp/rule/rule/

---------------------

[コンテンツを作成するにあたって]
Sharetubeは引用を行う場合ルールを徹底してまいります。
しっかりと利用規約を守った健全な活動をお願い申し上げます。
自分自身の文章を主として引用を従としたコンテンツ作成をお願いいたします。


[記事タイプに関して]
・筆者が全文を書く記事型
・引用と筆者の言葉を重ねるマルチ型
マルチ型のコンテンツを作成する場合は
割合としてオリジナル文字7：引用文字3の割合が好まれます。


[まとめを書くにあたってのノウハウ]
PVを集めるために絶対に必要な7つのルール
http://sharetube.jp/article/2814/


[参考にするまとめ一覧]
殿堂まとめ
http://sharetube.jp/famearticle/

---------------------

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube - シェアしたくなるコンテンツが集まる、集まる。
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
	//----------------------------------
	//お問い合わせからの連絡をメール送信
	//----------------------------------
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

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube - シェアしたくなるコンテンツが集まる、集まる。
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

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube - シェアしたくなるコンテンツが集まる、集まる。
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

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube - シェアしたくなるコンテンツが集まる、集まる。
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
	//-----------------------------------
	// 記事を削除した主旨を本人に報告する
	//-----------------------------------
	public static function article_delete_report($sharetube_user_data_array, $article_data_array) {
		$message = ("お世話になっております
Sharetubeサポートチームです

サービスをご利用いただきましてありがとうございます。


今回は".$sharetube_user_data_array['name']."様が書かれたまとめが
利用規約の第7条（禁止事項）に抵触しており
削除させていただいた事をご連絡させていただきます。

[該当まとめ]
".$article_data_array['title']."
".HTTP."article/".$article_data_array['link']."/

利用規約
http://sharetube.jp/rule/rule/ 

---

なお、違反部分を修正を行いまして、再度公開するための申請ができます。

[再編集する場合]
".HTTP."login/admin/matome/delete/edit/".$article_data_array['link']."/
利用規約違反の詳細を再編集ページ上記に追記いたしますので確認よろしくお願いいたします。

---

Sharetubeが考える理想のコンテンツは
筆者自身の文章と引用の文章比率が
5:5
または
7:3
が好ましいと考えております。
また、将来的にまとめよりのコンテンツより
記事よりのコンテンツをバックアップしていく方針ですので
よろしくお願い致します。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube - シェアしたくなるコンテンツが集まる、集まる。
発行：Sharetube[シェアチューブ]サポートチーム
http://sharetube.jp/

お問合せ: http://sharetube.jp/contact/
COPYRIGHT(C) Sharetube ALL RIGHTS RESERVED.");

		$post_array = array(
			'from'    => 'Sharetube <info@sharetube.jp>',
			'to'      => $sharetube_user_data_array['email'],
			'subject' => '利用規約違反があったため該当まとめを削除いたしました',
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
	//---------------------------------------------
	// 削除済み記事を申請した時に送られてくるメール
	//---------------------------------------------
	public static function delete_article_reapply_report($sharetube_user_data_array, $delete_article_data_array) {
		$message = ("削除済みのまとめが再編集され公開の申請が行われました。

[申請者]
".$sharetube_user_data_array['name']."
".HTTP."channel/".$sharetube_user_data_array['sharetube_id']."/

[申請されたまとめ]
".$delete_article_data_array['title']."
".HTTP."login/admin/matome/delete/edit/".$delete_article_data_array['link']."/");

		$post_array = array(
			'from'    => 'Sharetube <info@sharetube.jp>',
			'to'      => 'system_report@sharetube.jp',
			'subject' => '削除済みのまとめが再編集され公開の申請が行われました',
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
	//-------------------------------------
	// 削除済み記事を許可した時に送るメール
	//-------------------------------------
	public static function delete_article_reapply_authorization_report($sharetube_user_data_array, $delete_article_data_array) {
		$message = ("申請したまとめの公開許可がおりました。

[公開されたまとめ]
".$delete_article_data_array['title']."
".HTTP."article/".$delete_article_data_array['link']."/");

		$post_array = array(
			'from'    => 'Sharetube <info@sharetube.jp>',
			'to'      => $sharetube_user_data_array['email'],
			'subject' => '申請したまとめの公開許可がおりました',
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
	//---------------------------------------
	// 削除済み記事を許可しない時に送るメール
	//---------------------------------------
	public static function delete_article_reapply_no_authorization_report($sharetube_user_data_array, $delete_article_data_array) {
		$message = ("申請したまとめの公開許可がおりませんでした。

利用規約違反部分を再編集を行った上で申請をお願いいたします。

[申請したまとめ]
".$delete_article_data_array['title']."
".HTTP."login/admin/matome/delete/edit/".$delete_article_data_array['link']."/");

		$post_array = array(
			'from'    => 'Sharetube <info@sharetube.jp>',
			'to'      => $sharetube_user_data_array['email'],
			'subject' => '申請したまとめの公開許可がおりませんでした',
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
	//-----------------------------------
	// アクセス1週間のレポート NULLの場合
	//-----------------------------------
	public static function access_1week_null_report($sharetube_user_data_array) {
		$message = ("Sharetubeをご利用くださいましてありがとうございます。

1週間のアクセスレポートです
0 PV

---

残念ながらまだコンテンツが作成されていませんでした。



Sharetubeは日々成長しています
新たな機能も実装され新たなエディターも増え
コンテンツが書きやすい場所になっております。

".$sharetube_user_data_array['sharetube_id']."様も時間がある時にコンテンツを作成してみませんか？
わからない事がありましたら
お問い合わせ
http://sharetube.jp/contact/
からお気軽のご連絡ください。

ログイン
http://sharetube.jp/login/


Sharetubeはいつまでも待っています

[Vision]
全ての情報を最高のカタチで世界中に届ける

[Mission]
テキストメディアの中でシェア率No.1になる
エディターというシゴトを創出する

このビジョンとミッションを達成するために運営しております。

どうかお力をお貸しいただけたら幸いです。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube - シェアしたくなるコンテンツが集まる、集まる。
発行：Sharetube[シェアチューブ]サポートチーム
http://sharetube.jp/

お問合せ: http://sharetube.jp/contact/
COPYRIGHT(C) Sharetube ALL RIGHTS RESERVED.");

		$post_array = array(
			'from'    => 'Sharetube <info@sharetube.jp>',
			'to'      => $sharetube_user_data_array['email'],
			'subject' => '1週間のアクセスレポート',
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
//			Model_Mail_Basis::qbmail_send($post_array);
	}
	//------------------------
	// アクセス1週間のレポート
	//------------------------
	public static function access_1week_report($sharetube_user_data_array, $access_summary_value) {
		$message = ("Sharetubeをご利用くださいましてありがとうございます。

1週間のアクセスレポートです！
".$access_summary_value." PV

---

Sharetubeは日々成長しています
新たな機能も実装され新たなエディターも増え
コンテンツが書きやすい場所になっております。

わからない事がありましたら
お問い合わせ
http://sharetube.jp/contact/
からお気軽のご連絡ください。

ログイン
http://sharetube.jp/login/


Sharetubeはいつまでも待っています

[Vision]
全ての情報を最高のカタチで世界中に届ける

[Mission]
テキストメディアの中でシェア率No.1になる
エディターというシゴトを創出する

このビジョンとミッションを達成するために運営しております。

どうかお力をお貸しいただけたら幸いです。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Sharetube - シェアしたくなるコンテンツが集まる、集まる。
発行：Sharetube[シェアチューブ]サポートチーム
http://sharetube.jp/

お問合せ: http://sharetube.jp/contact/
COPYRIGHT(C) Sharetube ALL RIGHTS RESERVED.");


		$post_array = array(
			'from'    => 'Sharetube <info@sharetube.jp>',
			'to'      => $sharetube_user_data_array['email'],
			'subject' => '1週間のアクセスレポート',
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
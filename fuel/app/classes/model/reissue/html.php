<?php
/*
* 
* パスワード再設定 HTML関連クラス
* 
* 
* 
*/

class Model_Reissue_Html extends Model {
	//----------------------
	//パスワード変更HTML生成
	//----------------------
	public static function password_change_html_create() {
		$password_change_html = 
			'<div class="reissue">
				<div class="reissue_inner">
					<h2>パスワード再設定</h2>
					<p class="authentication">本人確認 認証しました</p>

					<p>再設定するパスワードを入力して下さい。</p>
					<form method="post" action="" name="reissue_form" class="reissue_form">
						<input type="hidden" size="20" value="aaaa" name="sharetube_id" id="sharetube_id">
						<!-- block -->
						<div class="reissue_block">
								<label for="new_password">新しいパスワード：</label>
								<input type="password" size="20" value="" name="new_password" id="new_password">
						</div>
						<!-- block -->
						<div class="reissue_block">
								<label for="new_password_confirm">新しいパスワード確認：</label>
								<input type="password" size="20" value="" name="new_password_confirm" id="new_password_confirm">
						</div>
						<!-- submit -->
						<input type="submit" value="送信" name="" class="o_8">
					</form>
				</div>
			</div>';
		return $password_change_html;
	}
}












<?php
//pre_var_dump($reissue_data);
if($reissue_data['user_check']) { ?>
			<div class="reissue">
				<div class="reissue_inner">
					<h2>パスワード再設定の手順メールを送りました</h2>
					<p>送信したメールに従いパスワードを設定して下さい。</p>
				</div>
			</div>
<?php
}
	else { ?>

			<div class="reissue">
				<div class="reissue_inner">
					<h2>パスワード再設定</h2>
					<p>Sharetubeに登録しているメールアドレス宛に再設定の手順をお送りします。</p>
					<form method="post" action="" name="reissue_form" class="reissue_form">
						<!-- block -->
						<div class="reissue_block">
								<label for="mail_address">メールアドレス：</label>
								<input type="text" size="20" value="<?php echo $reissue_data['mail_address']; ?>" name="mail_address" id="mail_address">
						</div>
						<?php
						if($reissue_data['post']) {
							if($reissue_data['user_email_check']) {} else {
							echo 
								'<!-- block -->
								<div class="reissue_block" style="color:red; font-size: 84%;">
									入力されたメールアドレスは間違っています。
								</div>';
							}
							if($reissue_data['user_email_check'] == true && $reissue_data['user_check'] == false) {
							echo 
								'<!-- block -->
								<div class="reissue_block" style="color:red; font-size: 84%;">
									入力されたメールアドレスのユーザーはいません。
								</div>';
							}
						}?>
						<!-- submit -->
						<input type="submit" value="送信" name="" class="o_8">
					</form>
				</div>
			</div>
	<?php
	} ?>




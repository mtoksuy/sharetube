			<?php
//			pre_var_dump($sign_data);
			?>


<div class="signup">
	<div class="signup_content clearfix">
	  <h2><strong>Sharetubeで情報をまとめてみよう</strong></h2>
	
	  <form method="post" id="signup_form" class="signup_form" action="">
	    <div class="field">
	      <input type="text" class="signup_form_sharetube_id" placeholder="Sharetube ID(半角英数字)" value="<?php echo $_POST["sharetube_id"]; ?>" maxlength="20" name="sharetube_id" autocomplete="off">
	    </div>
			<?php 
				if($sign_data["user_sharetube_id_check"] === null) {

				}
					else if(!$sign_data["user_sharetube_id_check"]) {
						 echo '<p class="red">既に登録されているidか登録できない文字列が含まれています</p>';
					}
						else {
						 echo '<p class="green">このidは使用できます</p>';
						}
 ?>
	    <div class="field">
	      <input type="email" class="signup_form_email" placeholder="メールアドレス" value="<?php echo $_POST["email"]; ?>" name="email" autocomplete="off">
	    </div>
			<?php 
				if($sign_data["user_email_check"] === null) {

				}
					else if(!$sign_data["user_email_check"]) {
						 echo '<p class="red">既に登録されているかメールアドレスが間違っています</p>';
					}
						else {
						 echo '<p class="green">このメールアドレスは使用できます</p>';
						}
 ?>
	    <div class="field">
	      <input type="password" class="signup_form_password" placeholder="パスワード(英数字のみ4文字以上)" name="password">
	    </div>
			<?php 
				if($sign_data["user_password_check"] === null) {

				}
					else if(!$sign_data["user_password_check"]) {
						 echo '<p class="red">4文字以下か使用できない文字列が含まれています</p>';
					} ?>
	    <button class="signup_form_button o_8" type="submit">
	      アカウント作成
	    </button>
	  </form>
<p>
アカウントを作成すると、<a href="<?php echo HTTP; ?>rule/rule/" target="_blank">利用規約</a>に同意したことになります。健全な活動を行ない、ユーザーに喜ばれるコンテンツを作成しましょう。</p>
	</div>
</div>
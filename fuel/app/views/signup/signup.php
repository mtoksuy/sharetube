			<?php
//			var_dump($sign_data);
			?>


<div style="float: left; background-color: #FCFCFC; margin: 0px 15px 0px 0px; width: 245px; height: 205px;">	
	<p class="m_0">
		<a href="http://sharetube.jp/curatorrecruitment/" target="_blank">
			<img width="245" height="205" title="" alt="" src="http://sharetube.jp/assets/img/article/image/image_3784.png" class="o_8">
		</a>
	</p>
</div>

<div class="signup">
	<div class="signup_content clearfix">
	  <h2><strong>Sharetubeで情報をまとめてみませんか?</strong> 登録する</h2>
	
	  <form method="post" id="signup_form" class="signup_form" action="">
	    <div class="field">
	      <input type="text" placeholder="Sharetube ID(半角英数字)" value="<?php echo $_POST["sharetube_id"]; ?>" maxlength="20" name="sharetube_id" autocomplete="off">
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
	      <input type="email" placeholder="メールアドレス" value="<?php echo $_POST["email"]; ?>" name="email" autocomplete="off">
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
	      <input type="password" placeholder="パスワード(英数字のみ4文字以上)" name="password">
	    </div>
			<?php 
				if($sign_data["user_password_check"] === null) {

				}
					else if(!$sign_data["user_password_check"]) {
						 echo '<p class="red">4文字以下か使用できない文字列が含まれています</p>';
					} ?>
	    <button class="signup_form_button o_8" type="submit">
	      Sharetubeに登録する
	    </button>
	  </form>
	</div>
</div>
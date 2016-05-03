<div class="article_list">
 <?php //var_dump( $content_data["user_data"]); ?>
<?php	
	// 編集後の文言表示
	if($content_data["user_data_edit_complete_text"]) { echo '<p style="margin-top: 0px; color: green; font-size: 125%; font-weight: bold;">'.$content_data["user_data_edit_complete_text"].'</p>';} ?>
	<form class="account_form" enctype="multipart/form-data" method="POST" action="<?php echo HTTP; ?>login/admin/userprofileedit/">
		<div class="control_group">
		  <label for="user_sharetube_id">Sharetube_id名</label>
		  <div class="controls">
		    <input id="user_sharetube_id" maxlength="15" name="sharetube_id" type="text" value="<?php echo $content_data["user_data"]["sharetube_id"];?>" disabled="disabled">
		  </div>
		</div> <!-- control_group -->

		<div class="control_group">
		  <label for="user_name">ユーザー名</label>
		  <div class="controls">
		    <input id="user_name" maxlength="64" name="name" type="text" placeholder="好きな名前を付けれます" value="<?php echo $content_data["user_data"]["name"];?>">
		  </div>
		</div> <!-- control_group -->

		<div class="control_group">
		  <label for="user_site">運営サイトURL</label>
		  <div class="controls">
		    <input id="user_site" maxlength="64" name="management_site_url" type="text" placeholder="運営しているサイトを表示できます" value="<?php echo $content_data["user_data"]["management_site_url"];?>">
		  </div>
		</div> <!-- control_group -->

		<div class="control_group">
		  <label for="user_profile">プロフィール</label>
		  <div class="controls">
				<textarea id="user_profile" placeholder="プロフィールを入力" name="profile_contents"><?php echo $content_data["user_data"]["profile_contents"];?></textarea>
		  </div>
		</div> <!-- control_group -->

		<div class="control_group">
		  <label for="user_icon">アイコン</label>
		  <div class="controls">
				<?php echo '<img class="now_user_icon" width="128" height="128" title="" alt="" src="'.HTTP.'assets/img/creators/icon/'.$content_data["user_data"]["profile_icon"].'">'; ?>
				<div class="upload_button">
					<input id="user_icon" type="file" name="profile_icon">
				</div>
		  </div>
		</div> <!-- control_group -->

		<div class="control_group">
		  <label for="user_twitter">Twitter_id</label>
		  <div class="controls">
		    <input id="user_twitter" name="twitter_id" type="text" placeholder="Twitterリンクを表示できます" value="<?php echo $content_data["user_data"]["twitter_id"];?>">
		  </div>
		</div> <!-- control_group -->

		<div class="control_group">
		  <label for="user_facebook">Facebook_id</label>
		  <div class="controls">
		    <input id="user_facebook" name="facebook_id" type="text" placeholder="Facebookリンクを表示できます" value="<?php echo $content_data["user_data"]["facebook_id"];?>">
		  </div>
		</div> <!-- control_group -->

	  <button type="submit" id="submit" class="submit">変更を保存</button>
	</form>
</div>

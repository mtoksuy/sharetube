<div class="article_list">
 <?php //var_dump( $content_data["user_data"]); ?>



 <?php // pre_var_dump( (int)$content_data['user_data']['mail_delivery_ok']); ?>


<?php	
	// 編集後の文言表示
	if($content_data["user_data_edit_complete_text"]) { echo '<p style="margin-top: 0px; color: green; font-size: 125%; font-weight: bold;">'.$content_data["user_data_edit_complete_text"].'</p>';} ?>

	<form class="account_form" enctype="multipart/form-data" method="post" action="<?php echo HTTP; ?>login/admin/usersetupedit/">
		<h2 class="control_h2">メール設定</h2>
		<div class="control_group">
			<input type="hidden" name="user_hidden" value="1">
			<input type="checkbox" id="user_mail_delivery_ok" name="user_mail_delivery_ok" value="1" <?php if((int)$content_data['user_data']['mail_delivery_ok'] == 1){ echo 'checked="checked"'; } ?>>
		  <label for="user_mail_delivery_ok">公式からのメール配信を受け取る</label>
		  <div class="controls">

		  </div>
		</div> <!-- control_group -->
	  <button type="submit" id="submit" class="submit">変更を保存</button>
	</form>
</div>

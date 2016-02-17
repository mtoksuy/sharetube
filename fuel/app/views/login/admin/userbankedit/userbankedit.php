<div class="article_list">
 <?php //var_dump( $content_data["user_data"]); ?>
<?php	

	// 編集後の文言表示
	if($content_data["user_data_edit_complete_text"]) { echo '<p style="margin-top: 0px; color: green; font-size: 125%; font-weight: bold;">'.$content_data["user_data_edit_complete_text"].'</p>';} ?>



	<form class="account_form" enctype="multipart/form-data" method="POST" action="<?php echo HTTP; ?>login/admin/userbankedit/">
		<div class="control_group">
		  <label for="bank_name">銀行名</label>
		  <div class="controls">
		    <input id="bank_name" maxlength="64" name="bank_name" type="text" value="<?php echo $content_data["user_data"]["bank_name"];?>">
		  </div>
		</div> <!-- control_group -->


		<div class="control_group">
		  <label for="account_holder">口座名義人(口座の名義人の名前を、全角カタカナで入力してください)</label>
		  <div class="controls">
		    <input id="account_holder" maxlength="64" name="account_holder" type="text" value="<?php echo $content_data["user_data"]["account_holder"];?>">
		  </div>
		</div> <!-- control_group -->


		<div class="control_group">
		  <label for="account_type">口座の種類</label>
		  <div class="controls">
		    <input id="account_type" maxlength="64" name="account_type" type="text" value="<?php echo $content_data["user_data"]["account_type"];?>">
		  </div>
		</div> <!-- control_group -->


		<div class="control_group">
		  <label for="branch_code">支店コード(3けた、半角数字)</label>
		  <div class="controls">
		    <input id="branch_code" maxlength="64" name="branch_code" type="text" value="<?php echo $content_data["user_data"]["branch_code"];?>">
		  </div>
		</div> <!-- control_group -->


		<div class="control_group">
		  <label for="account_number">口座番号（7けた、半角数字　※口座番号が7けた未満の場合は、前に0をつけて全部で7けたになるように入力してください）</label>
		  <div class="controls">
		    <input id="account_number" maxlength="64" name="account_number" type="text" value="<?php echo $content_data["user_data"]["account_number"];?>">
		  </div>
		</div> <!-- control_group -->

	  <button type="submit" id="submit" class="submit">変更を保存</button>
	</form>
</div>

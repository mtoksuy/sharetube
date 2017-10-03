//----------------
//読み込み後の処理
//----------------
$(function() {
	//--------------------------------
	//Sharetube_idリアルタイムチェック
	//--------------------------------
	$('.signup').on( {
		'change': function() {

		},
		'keypress': function() {

		},
		'keyup': function() {
			// 必要変数
			var signup_form_sharetube_id_element = $(this);
			// 2文字列以上から
			if($(this).val().length > 1) {
				// ajax
				$.ajax({
					type: 'POST', 
					url: http + 'ajax/signup/sharetubeidcheck/',
					data: {
						sharetube_id : $(this).val(),
					},
					dataType: 'json',
					cache: false,
				  success: function(data) {
						// 使用できるidであれば
						if(data['sharetube_id_check']) {
							var add_element = '<span class="real_time_check check_green"><span class="typcn typcn-tick"></span><span class="check_green">使用できます</span></span>';
							var rewrite_add_element = '<span class="typcn typcn-tick check_green"></span><span class="check_green">使用できます</span>';
						}
							// 使用できないidであれば
							else {
								var add_element = '<span class="real_time_check"><span class="typcn typcn-times red"></span><span class="red">すでに使用されています</span></span>';
								var rewrite_add_element = '<span class="typcn typcn-times red"></span><span class="red">すでに使用されています</span>';
							}
						// 書き換え
						if(signup_form_sharetube_id_element.next('.real_time_check')[0]) {
							signup_form_sharetube_id_element.next('.real_time_check').html(rewrite_add_element);
						}
							// 書き込み
							else {
								signup_form_sharetube_id_element.after(add_element);
							}
				  },
					// エラー処理
				  error: function(data) {
			
				  },
				  complete: function(data) {
			
				  }
				}); // $.ajax({
			} // if($(this).val().length > 1) {
				// 1文字以下になった場合
				else {
					// チェック文言削除
					signup_form_sharetube_id_element.next('.real_time_check').remove();
				}
		},
	}, '.signup_form_sharetube_id');
	//----------------------------------
	//メールアドレスリアルタイムチェック
	//----------------------------------
	$('.signup').on( {
		'change': function() {

		},
		'keypress': function() {

		},
		'keyup': function() {
			// 必要変数
			var signup_form_email_element = $(this);
			// 2文字列以上から
			if($(this).val().length > 1) {
				// ajax
				$.ajax({
					type: 'POST', 
					url: http + 'ajax/signup/emailcheck/',
					data: {
						email : $(this).val(),
					},
					dataType: 'json',
					cache: false,
				  success: function(data) {
						// 使用できるidであれば
						if(data['email_check']) {
							var add_element = '<span class="real_time_check check_green"><span class="typcn typcn-tick"></span><span class="check_green">使用できます</span></span>';
							var rewrite_add_element = '<span class="typcn typcn-tick check_green"></span><span class="check_green">使用できます</span>';
						}
							// 使用できないidであれば
							else {
								var add_element = '<span class="real_time_check"><span class="typcn typcn-times red"></span><span class="red">使用できません</span></span>';
								var rewrite_add_element = '<span class="typcn typcn-times red"></span><span class="red">使用できません</span>';
							}
						// 書き換え
						if(signup_form_email_element.next('.real_time_check')[0]) {
							signup_form_email_element.next('.real_time_check').html(rewrite_add_element);
						}
							// 書き込み
							else {
								signup_form_email_element.after(add_element);
							}
				  },
					// エラー処理
				  error: function(data) {
			
				  },
				  complete: function(data) {
			
				  }
				}); // $.ajax({
			} // if($(this).val().length > 1) {
				// 1文字以下になった場合
				else {
					// チェック文言削除
					signup_form_email_element.next('.real_time_check').remove();
				}
		},
	}, '.signup_form_email');
	//------------------------------
	//パスワードリアルタイムチェック
	//------------------------------
	$('.signup').on( {
		'change': function() {

		},
		'keypress': function() {

		},
		'keyup': function() {
			// 必要変数
			var signup_form_password_element = $(this);
			// 2文字列以上から
			if($(this).val().length > 1) {
				// ajax
				$.ajax({
					type: 'POST', 
					url: http + 'ajax/signup/passwordcheck/',
					data: {
						password : $(this).val(),
					},
					dataType: 'json',
					cache: false,
				  success: function(data) {
						// 使用できるidであれば
						if(data['password_check']) {
							var add_element = '<span class="real_time_check check_green"><span class="typcn typcn-tick"></span><span class="check_green">使用できます</span></span>';
							var rewrite_add_element = '<span class="typcn typcn-tick check_green"></span><span class="check_green">使用できます</span>';
						}
							// 使用できないidであれば
							else {
								var add_element = '<span class="real_time_check"><span class="typcn typcn-times red"></span><span class="red">使用できません</span></span>';
								var rewrite_add_element = '<span class="typcn typcn-times red"></span><span class="red">使用できません</span>';
							}
						// 書き換え
						if(signup_form_password_element.next('.real_time_check')[0]) {
							signup_form_password_element.next('.real_time_check').html(rewrite_add_element);
						}
							// 書き込み
							else {
								signup_form_password_element.after(add_element);
							}
				  },
					// エラー処理
				  error: function(data) {
			
				  },
				  complete: function(data) {
			
				  }
				}); // $.ajax({
			} // if($(this).val().length > 1) {
				// 1文字以下になった場合
				else {
					// チェック文言削除
					signup_form_password_element.next('.real_time_check').remove();
				}
		},
	}, '.signup_form_password');
}); // $(function() {
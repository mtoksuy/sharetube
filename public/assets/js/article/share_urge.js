	//----------------
	//読み込み後の処理
	//----------------
	$(function() {
		var share_urge_flag              = true;
		var share_urge_social_share_flag = false;
		var share_urge_bottom_flag       = false;

		$('.share_urge_contents').height();
		$('.share_urge_contents').css( {
			top: '-' + $('.share_urge_contents').height() + 'px'
		});
		


	$(window).scroll(function () {
		//----------------------
		//スクロール挙動確認表示
		//----------------------
    var pos                   = $('.social_share').position();
		var main_padding_top      = $('.main').css('padding-top').replace('px', '');
		// intにキャストする
		main_padding_top          = eval(main_padding_top);

		var scrollBottom              = $(window).scrollTop() + $(window).height();
		var social_share_position = $('.social_share').offset().top - $(window).scrollTop();

		// フラグが立っていたら
		if(share_urge_flag == true) {
			// 一番下に付いたら
			if($('html body').height() == scrollBottom) {
				// 表示する
				$('.share_urge_contents').css( {
					display: 'block'
				});
				$('.share_urge_contents').animate( {
					'top': '0px',
				});
				share_urge_flag        = false;
				share_urge_bottom_flag = true;
			}
				// ボタンを飛び越えたら
				else if(social_share_position < 0 && social_share_position > -200) {
/*

ボタンを飛び越えたら表示するのを一時的に止めます
2014年 05月09日

					// 表示する
					$('.share_urge_contents').css( {
						display: 'block'
					});
					$('.share_urge_contents').animate( {
						'top': '0px',
					});
*/
					share_urge_flag              = false;
					share_urge_social_share_flag = true;
				}
		}
			// フラグが立っていない場合
			else {
				// 
				if(share_urge_social_share_flag == true) {
					if(social_share_position > 200 || social_share_position < -200) {
						// 非表示にする
						$('.share_urge_contents').animate( {
							'top': '-' + $('.share_urge_contents').height() + 'px',
						}, function() {
							$('.share_urge_contents').css( {
								display: 'none'
							});
						});
						share_urge_social_share_flag = false;
						share_urge_flag              = true;
					}
				}
				// 
				if(share_urge_bottom_flag == true) {
					if(($('html body').height() - 100) > scrollBottom) {
						// 非表示にする
						$('.share_urge_contents').animate( {
							'top': '-' + $('.share_urge_contents').height() + 'px',
						}, function() {
							$('.share_urge_contents').css( {
								display: 'none'
							});
						});
						share_urge_bottom_flag = false;
						share_urge_flag        = true;
					}
				}
			}
	});




		//--------------------
		//記事読み込みajax発火
		//--------------------
//		if(($('html body').height() - scrollBottom)  <= 400) {














	});
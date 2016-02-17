//----------------
//読み込み後の処理
//----------------
$(function() {
// windowがスクロールされた時に実行する処理
$(window).scroll(function() {
if($(window).scrollTop()  > 300) {
//	p('プギャー'); 練習
}
	else {

	}
});
/***************************************
選択文字を特定のタグで囲んで置換する関数
***************************************/
function selecte_text_replace(start_tag, end_tag) {
/*
http://d.hatena.ne.jp/ja9/20100917/1284146159
HTMLドキュメント内の選択されたテキスト/HTMLを取得する
$.getSelection([mode = 'text'])

テキストボックス/エリアの選択されたテキストを取得する
getSelection()

テキストボックス/エリアの選択されたテキストを置換する
replaceSelection(text[, caret = 'keep'])


テキストボックス/エリアの選択されたテキストの前に文字列を挿入する
insertBeforeSelection(text[, caret = 'keep'])

テキストボックス/エリアの選択されたテキストの後に文字列を挿入する
insertAfterSelection(text[, caret = 'keep'])

テキストボックス/エリアの選択範囲を取得する
getCaretPos()

テキストボックス/エリアの選択範囲を設定する
setCaretPos(range)

うーん、これも使えない・・・2015.09.11 松岡

*/


		// 選択範囲オブジェクト取得
		var obj           = document.getSelection();
		// 選択範囲の文字列を取得
		var selected_text = obj.toString();

		// 半角空白になった改行を戻す
		var selected_text = selected_text.replace(' ', '\n');
		// 選択文字がある場合
		if(selected_text) {
			// 選択文字の親タグ取得
			var selected_text_parent_tag = obj.anchorNode.parentNode;
			// 選択文字の親タグ取得(文字列)
			var selected_text_parent_tag_str = selected_text_parent_tag.nodeName;
			// 選択文字の親クラスネーム取得(文字列)
			var selected_text_parent_class_str = obj.anchorNode.parentElement.className;
			// 上層タグがPREである場合 か 親クラスが tweet_content_text だった場合
			if(selected_text_parent_tag_str === 'PRE' | selected_text_parent_class_str === 'tweet_content_text') {
				//元のタグのHTML全体取得
				var ntvstr = selected_text_parent_tag.innerHTML;
				// 半角空白のエンティティ戻す
				selected_text = selected_text.replace('\n', ' ');
				//<、>をエンティティに変換する
				selected_text = text_entity_conversion(selected_text);
				//<、>をエンティティに変換する
				ntvstr = text_entity_conversion(ntvstr);

				// (と)を変換
				selected_text = selected_text.replace(/\(/g, '左キャプテンシップヨーソロー');
				selected_text = selected_text.replace(/\)/g, '右キャプテンシップヨーソロー');
				ntvstr        = ntvstr.replace(/\(/g, '左キャプテンシップヨーソロー');
				ntvstr        = ntvstr.replace(/\)/g, '右キャプテンシップヨーソロー');
				// |を変換
				selected_text = selected_text.replace(/\|/g, '猫窓');
				ntvstr        = ntvstr.replace(/\|/g, '猫窓');
				// +を変換
				selected_text = selected_text.replace(/\+/g, 'プラス猫');
				ntvstr        = ntvstr.replace(/\+/g, 'プラス猫');
				// *を変換
				selected_text = selected_text.replace(/\*/g, 'ケツ猫');
				ntvstr        = ntvstr.replace(/\*/g, 'ケツ猫');
				// ^を変換
				selected_text = selected_text.replace(/\^/g, 'にゃん猫');
				ntvstr        = ntvstr.replace(/\^/g, 'にゃん猫');

				// タグ差し込み
				re  = new RegExp(selected_text);
//				p(re); // 肝です。
//  			p(ntvstr);
				var res  = ntvstr.replace(re, '<'+start_tag+'>'+selected_text+'</'+end_tag+'>');

				//<、>をエンティティを戻す
				res = text_entity_return(res);
				// (と)を元に戻す
				res = res.replace(/左キャプテンシップヨーソロー/g,'(');
				res = res.replace(/右キャプテンシップヨーソロー/g,')');
				// |を元に戻す
				res = res.replace(/猫窓/g,'|');
				// +を元に戻す
				res = res.replace(/プラス猫/g,'+');
				// *を元に戻す
				res = res.replace(/ケツ猫/g,'*');
				// ^を元に戻す
				res = res.replace(/にゃん猫/g,'^');

				// 更新
				selected_text_parent_tag.innerHTML = res;
			} // if(selected_text_parent_class_str === 'PRE') {
		} // if(selected_text) {
			// 選択文字がない場合
			else {
	
		}
//		return ;
}






function print(str){
  document.write(str + "<br />");
}

function slicestr(start){
  print("開始位置 : " + start);

  var index = str_obj.indexOf(substr, start);

  print("出現位置 : " + index);

  str1 = str_obj.slice(0, index);
  str2 = str_obj.slice(index, index + substr.length);
  str3 = str_obj.slice(index + substr.length);

  print(str1 + "[" + str2 + "]" + str3);
}

var str_obj = "東京,大阪,神奈川,大阪,東京,大阪";
var substr = "大阪";


//slicestr(5);











/***********************
選択文字を中見出しにする
***********************/
$('.text_design_tool').on( {
	'click' : function(event) {
		selecte_text_replace('h3 class="h3_heading_1"', 'h3');
	}
}, '.text_design_tool_content_list_h3_button');
/***********************
選択文字を小見出しにする
***********************/
$('.text_design_tool').on( {
	'click' : function(event) {
		selecte_text_replace('h4 class="h4_heading_1"', 'h4');
	}
}, '.text_design_tool_content_list_h4_button');
/***************************
選択文字をストロングににする
***************************/
$('.text_design_tool').on( {
	'click' : function(event) {
		selecte_text_replace('strong', 'strong');
	}
}, '.text_design_tool_content_list_strong_button');

/***********************
選択文字を太文字ににする
***********************/
$('.text_design_tool').on( {
	'click' : function(event) {
		selecte_text_replace('b', 'b');
	}
}, '.text_design_tool_content_list_bold_button');
/*************************
選択文字をマーカーでなぞる
*************************/
$('.text_design_tool').on( {
	'click' : function(event) {
		selecte_text_replace('em class="marker_1"', 'em');
	}
}, '.text_design_tool_content_list_marker_button');
/*****************
選択文字を赤にする
*****************/
$('.text_design_tool').on( {
	'click' : function(event) {
		selecte_text_replace('span class="red"', 'span');
	}
}, '.text_design_tool_content_list_text_red_color_button');

/***********************
選択文字を大きくする・中
***********************/
$('.text_design_tool').on( {
	'click' : function(event) {
		selecte_text_replace('span class="f_s_125"', 'span');
	}
}, '.text_design_tool_content_list_big_text_1_button');
/***************************
選択文字を大きくする・中[赤]
***************************/
$('.text_design_tool').on( {
	'click' : function(event) {
		selecte_text_replace('span class="f_s_125 red"', 'span');
	}
}, '.text_design_tool_content_list_big_text_1_red_color_button');
/***********************
選択文字を大きくする・大
***********************/
$('.text_design_tool').on( {
	'click' : function(event) {
		selecte_text_replace('span class="f_s_150"', 'span');
	}
}, '.text_design_tool_content_list_big_text_2_button');
/***************************
選択文字を大きくする・大[赤]
***************************/
$('.text_design_tool').on( {
	'click' : function(event) {
		selecte_text_replace('span class="f_s_150 red"', 'span');
	}
}, '.text_design_tool_content_list_big_text_2_red_color_button');
/*************************
選択文字を大きくする・特大
*************************/
$('.text_design_tool').on( {
	'click' : function(event) {
		selecte_text_replace('span class="f_s_175"', 'span');
	}
}, '.text_design_tool_content_list_big_text_3_button');
/*****************************
選択文字を大きくする・特大[赤]
*****************************/
$('.text_design_tool').on( {
	'click' : function(event) {
		selecte_text_replace('span class="f_s_175 red"', 'span');
	}
}, '.text_design_tool_content_list_big_text_3_red_color_button');




/*****************
文字装飾ツール変更
*****************/
$('.text_design_tool').on( {
	'click' : function(event) {
		$(this).parents('.text_design_tool').html(
'<div class="text_design_tool clearfix">\
	<div class="text_design_tool_content">\
		<span class="text_design_tool_content_title"><span class="typcn typcn-pen"></span>文字装飾ツール</span>\
		<ul class="text_design_tool_content_list clearfix">\
			<li class="text_design_tool_content_list_change_2"><span class="typcn typcn-arrow-repeat"></span></li>\
			<li class="text_design_tool_content_list_text_red_color">\
				<input type="button" class="text_design_tool_content_list_text_red_color_button" value="文字[赤]">\
			</li>\
			<li class="text_design_tool_content_list_big_text_1">\
				<input type="button" class="text_design_tool_content_list_big_text_1_button" value="文字・中">\
			</li>\
			<li class="text_design_tool_content_list_big_text_2_red_color">\
				<input type="button" class="text_design_tool_content_list_big_text_1_red_color_button" value="文字・中[赤]">\
			</li>\
			<li class="text_design_tool_content_list_big_text_2">\
				<input type="button" class="text_design_tool_content_list_big_text_2_button" value="文字・大">\
			</li>\
			<li class="text_design_tool_content_list_big_text_2_red_color">\
				<input type="button" class="text_design_tool_content_list_big_text_2_red_color_button" value="文字・大[赤]">\
			</li>\
			<li class="text_design_tool_content_list_big_text_3">\
				<input type="button" class="text_design_tool_content_list_big_text_3_button" value="文字・特大">\
			</li>\
			<li class="text_design_tool_content_list_big_text_2_red_color">\
				<input type="button" class="text_design_tool_content_list_big_text_3_red_color_button" value="文字・特大[赤]">\
			</li>\
		</ul>\
	</div>\
</div>');
	}
}, '.text_design_tool_content_list_change');
/******************
文字装飾ツール変更2
******************/
$('.text_design_tool').on( {
	'click' : function(event) {
		$(this).parents('.text_design_tool').html(
'<div class="text_design_tool clearfix">\
	<div class="text_design_tool_content">\
		<span class="text_design_tool_content_title"><span class="typcn typcn-pen"></span>文字装飾ツール</span>\
		<ul class="text_design_tool_content_list clearfix">\
			<li class="text_design_tool_content_list_change"><span class="typcn typcn-arrow-repeat"></span></li>\
			<li class="text_design_tool_content_list_h3">\
				<input type="button" class="text_design_tool_content_list_h3_button" value="中見出し">\
			</li>\
			<li class="text_design_tool_content_list_h4">\
				<input type="button" class="text_design_tool_content_list_h4_button" value="小見出し">\
			</li>\
			<li class="text_design_tool_content_list_strong">\
				<input type="button" class="text_design_tool_content_list_strong_button" value="強調する[SEO]">\
			</li>\
			<li class="text_design_tool_content_list_bold">\
				<input type="button" class="text_design_tool_content_list_bold_button" value="太くする">\
			</li>\
			<li class="text_design_tool_content_list_marker">\
				<input type="button" class="text_design_tool_content_list_marker_button" value="マーカー">\
			</li>\
		</ul>\
	</div>\
</div>');
	}
}, '.text_design_tool_content_list_change_2');



//----------------
//ブラウザの大きさ
//----------------
$(window).width();
$(window).height();
//----------------------
//スクロールしている数値
//----------------------
$(window).scrollTop();
//------------
//一番底の数値
//------------
$('html').height();
});
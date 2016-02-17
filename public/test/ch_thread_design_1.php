<!DOCTYPE html>
<html>
	<head>
		<title>2ちゃんねるスレッドテキストベースまとめツール Var.1.00</title>
		<!-- meta -->
		<meta charset="UTF-8">
		<link rel="stylesheet" href="http://sharetube.jp/assets/css/common/common.css" type="text/css">
		<link rel="stylesheet" href="http://sharetube.jp/assets/css/article/common.css" type="text/css">
	</head>
	<body>
<h1>2ちゃんねるスレッドテキストベースまとめツール Var.1.00</h1>

<p class="m_t_30">URLを読み込んだり、ファイルを読み込んでスレッドをまとめるツールばかりだったので、テキストベースでまとめられるツールを作成いたしました。なぜテキストベースなのかというと、スレッドをそのままエディタへコピペして編集したほうが早いからです。</p>

<p>なお、現在対応している形式は</p>

<p class="m_0">1 ：名無しさん＠お腹いっぱい。：2013/03/02(土) 12:30:44.26 ID:j3+senoR</p>
<p class="m_0">のみです</p>
<p><strong>投稿番号、名前、日付、IDの順番通りでないと作成できない仕様</strong>になっています。</p>

<p class="m_0">432 ：夢見る名無しさん：2014/09/29(月) 21:57:21.12 0</p>
<p>などの形式はまだ未対応です・・・</p>


<p class="m_0">例：（コピペして、まとめHTML作成をクリックすると生成されます）</p>
<p class="m_0">1 ：名無しさん＠お腹いっぱい。：2013/03/02(土) 12:30:44.26 ID:j3+senoR</p>
<p>    サブカルニュースを配信しているニュースサイトを紹介していこう。</p>

<p class="m_0">90 ：名無しさん＠お腹いっぱい。：2013/12/09(月) 07:39:41.53 ID:TV7IPs6n</p>
<p>    ttp://www.nhk.or.jp/lnews/okayama/4023445911.html?t=1386542262733</p>

<p>--------------------------------------</p>


<p>8時間くらいのやっつけで作ったのでご容赦ください。必要に迫られたら順次対応いたします。スレ主や、特定IDの発言を大きくしたり、色を変えるくらいのバージョンアップは予定しています。ご連絡は<a href="http://sharetube.jp/" target="_blank">Sharetube</a>にあるコンタクトか、僕のTwitterアカウント<a href="https://twitter.com/mtoksuy" target="_blank">@mtoksuy</a>へ宜しくお願い致します。</p>



<p class="m_0">コピペ場所</p>
<form class="" action="" method="post">
	<textarea name="ch_thread_content" style="width: 800px; height: 300px;"></textarea>
	<input type="submit" name="submit" value="まとめHTML生成">
</form>
<?php

//var_dump($_POST["ch_thread_content"]);

$ch_thread_content = '
53 ：名無しさん：2014/09/07(日) 11:07:17.28 ID:yzEQthMP0
    新宿で二時から飲みましょう
    途中参加も歓迎です

    toppopo_001@outlook.jp

54 ：名無しさん：2014/09/07(日) 13:57:40.36 ID:L0kVQzSW0
    新宿飲みは地下トラノコに入りました

55 ：名無しさん：2014/09/07(日) 14:16:29.09 ID:HiNuQnhG0
    カドクラに二人です

56 ：名無しさん：2014/09/07(日) 14:35:23.24 ID:Dlwqxck/0
    とりあえず今四人で後から二人予定です

';
//------------------
//改行コード変換関数
//------------------
function convertEOL($string, $to = "\n") {   
	return preg_replace("/\r\n|\r|\n/", $to, $string);
}
//print_r($ch_thread_content);

$ch_thread_content = $_POST["ch_thread_content"];
$ch_thread_content = convertEOL($ch_thread_content);
$ch_thread_content .= '
';
//print_r($ch_thread_content);

// pタグ仕分けに使うカウント
$sorting_count             = 0;
$comment_pp_data_array     = array();
$comment_pp_end_data_array = array();
$ch_thread_data_array      = array();

// comment_dataタグ挿入
// timeデータが違うのがあるのでここを修正する（イマココ）
// m_0が文章以外にも挿入されているバグを直すこと

$pattern = "/([0-9]+\s：)(.*：)([0-9]{4}\/[0-9]{2}\/[0-9]{2}.{1,5}\s[0-9]{2}:[0-9]{2}:[0-9]{2})(\sID:.+)/"; // 古い
$pattern = "/([0-9]+\s：)(.*：)([0-9]{4}\/[0-9]{2}\/[0-9]{2}.{1,5}\s[0-9]{2}:[0-9]{2}:.+?)(\sID:.+)/";      // 新しい
$replacement = 		'<div class="comment_data">
			<span class="comment_number">$1</span><span class="comment_name">$2</span><span class="comment_time">$3</span><span class="comment_id">$4</span>
		</div>';
$ch_thread_content_falf_html = preg_replace($pattern, $replacement, $ch_thread_content);
//var_dump($ch_thread_content_falf_html);

// 初期設定（改行を弐弐に変換）
$pattern = '/[\n|\r|\nr|\t]/';
$pattern = '/[\n]/';
$replacement = '弐弐';
$ch_thread_content_falf_html = preg_replace($pattern, $replacement, $ch_thread_content_falf_html);
//var_dump($ch_thread_content_falf_html);

/*
<div class="comment_data">弐弐			<span class="comment_number">2 ：</span><span class="comment_name">名無しさん：</span><span class="comment_time">2014/09/01(月) 00:44:13.39</span><span class="comment_id"> ID:rRggIlpt0
</span>弐弐		</div>弐弐
弐弐>>1
弐弐乙です 
弐弐
*/
// コンテンツデータarray取得（末尾以外）
$pattern = "/\<\/div\>.+?\<div class/";
if(preg_match_all($pattern, $ch_thread_content_falf_html, $comment_data_array)) {
//	var_dump($comment_data_array[0]);

	// コンテンツ整理
	foreach($comment_data_array[0] as $key => $value) {

		// 改行戻し
		$pattern = "/弐弐/";
		$replacement = "
";
		$content_1 = preg_replace($pattern, $replacement, $value);
//		var_dump($content_1);

		// </div>削除
		$pattern = "/\<\/div\>/";
		$replacement = "";
		$content_2 = preg_replace($pattern, $replacement, $content_1);
//		var_dump($content_2);

		// <div class削除
		$pattern = "/\<div class/";
		$replacement = "";
		$content_3 = preg_replace($pattern, $replacement, $content_2);
//		var_dump($content_3);
//		print_r($content_3);

		// 改行1か2以上かで振り分け
		$pattern = "/(.+\n\n)|(.+\n)/";
		if(preg_match_all($pattern, $content_3, $comment_p_data_array)) {
//			var_dump($comment_p_data_array);
//			var_dump($comment_p_data_array[0]);
//			var_dump($comment_p_data_array[1]);
//			var_dump($comment_p_data_array[2]);

			// 振り分けたコンテンツにpタグ付けしていく
			foreach($comment_p_data_array[0] as $key => $value) {
//				var_dump($key);
//				var_dump($value);

				// 普通のp
				if($value == $comment_p_data_array[1][$key]) {
//					var_dump($comment_p_data_array[1][$key]);
					// コンテンツをpタグに入れる
					$pattern = "/(.+\n\n)/";
					$replacement = '<p>$1</p>';
					$p_html = preg_replace($pattern, $replacement, $comment_p_data_array[1][$key]);
					$comment_p_data_array[0][$key] = $p_html;
				}
				// m_0のp
				if($value == $comment_p_data_array[2][$key]) {
//					print_r($comment_p_data_array[2][$key]);

					// コンテンツをpタグ（m_0）に入れる
					$pattern = "/(.+\n)/";
					$replacement = '<p class="m_0">$1</p>';
					$p_html = preg_replace($pattern, $replacement, $comment_p_data_array[2][$key]);
					$comment_p_data_array[0][$key] = $p_html;
				}
			} // foreach($comment_p_data_array[0] as $key => $value) {
		} // if(preg_match_all($pattern, $content_3, $comment_p_data_array)) {
//		var_dump($comment_p_data_array[0]);
		// pタグ付けしたコメントを整理整頓して順番通りにする
		foreach($comment_p_data_array[0] as $key => $value) {
			$comment_pp_data_array[$sorting_count] .= $value;
		}
		// コメントの順番を取得する大事なカウント
		$sorting_count++;
	} // foreach($comment_data_array[0] as $key => $value) {

	// ひとまず完成
//		var_dump($comment_pp_data_array);
} // if(preg_match_all($pattern, $ch_thread_content_falf_html, $comment_data_array)) {





// 末尾のコンテンツ抽出
$pattern = "/\<div class=\"comment_data\"\>.+\<\/div\>/";
$replacement = '';
$comment_end_content = preg_replace($pattern, $replacement, $ch_thread_content_falf_html);
//print_r($comment_end_content);
echo '<br>';

		// 改行戻し
		$pattern = "/弐弐/";
		$replacement = "
";
		$content_1 = preg_replace($pattern, $replacement, $comment_end_content);
//		var_dump($content_1);

		// 改行1か2以上かで振り分け
		$pattern = "/(.+\n\n)|(.+\n)/";
		if(preg_match_all($pattern, $content_1, $comment_p_end_data_array)) {
//			var_dump($comment_p_end_data_array);
//			var_dump($comment_p_end_data_array[0]);
//			var_dump($comment_p_end_data_array[1]);
//			var_dump($comment_p_end_data_array[2]);

			// 振り分けたコンテンツにpタグ付けしていく
			foreach($comment_p_end_data_array[0] as $key => $value) {
//				var_dump($key);
//				var_dump($value);

				// 普通のp
				if($value == $comment_p_end_data_array[1][$key]) {
//					var_dump($comment_p_data_array[1][$key]);
					// コンテンツをpタグに入れる
					$pattern = "/(.+\n\n)/";
					$replacement = '<p>$1</p>';
					$p_html = preg_replace($pattern, $replacement, $comment_p_end_data_array[1][$key]);
					$comment_p_end_data_array[0][$key] = $p_html;
				}
				// m_0のp
				if($value == $comment_p_end_data_array[2][$key]) {
					// コンテンツをpタグ（m_0）に入れる
					$pattern = "/(.+\n)/";
					$replacement = '<p class="m_0">$1</p>';
					$p_html = preg_replace($pattern, $replacement, $comment_p_end_data_array[2][$key]);
					$comment_p_end_data_array[0][$key] = $p_html;
				}
			}
		}
		// pタグ付けしたコメントを整理整頓して順番通りにする
		foreach($comment_p_end_data_array[0] as $key => $value) {
			$comment_pp_end_data_array[0] .= $value;
		}
		// 末尾のコメントを追加
		array_push($comment_pp_data_array, $comment_pp_end_data_array[0]);
		// コメントデータ完成系
//		var_dump($comment_pp_data_array);

// comment_data_array取得
$pattern = "/\<div class=\"comment_data\"\>.+?\<\/div\>/";
if(preg_match_all($pattern, $ch_thread_content_falf_html, $comment_data_array)) {
//	var_dump($comment_data_array);
}
// comment_data_arrayの改行戻し
foreach($comment_data_array as $key => $value)  {
//	var_dump($value);

		// 改行戻し
		$pattern = "/弐弐/";
		$replacement = "
";
		$comment_data_array = preg_replace($pattern, $replacement, $value);
}
//	var_dump($comment_data_array);


//		var_dump($comment_pp_data_array);
foreach($comment_data_array as $key => $value) {
//	var_dump($value);
	// array版
	$ch_thread_data_array[$key] .= '<div class="comment">'.$value.$comment_pp_data_array[$key].'</div>';
	// HTML版
	$ch_thread_data_html .= '<div class="comment">'.$value.$comment_pp_data_array[$key].'</div>';
}
$ch_thread_data_html = '<div class="ch_thread_design_1">'.$ch_thread_data_html.'</div>';


if($ch_thread_data_html != '<div class="ch_thread_design_1"></div>') {
	echo '<p class="m_0">〜〜まとめHTML内容〜〜</p>';
print_r($ch_thread_data_html);
//var_dump($ch_thread_data_html);
}

echo '<p class="m_0">生成されたコンテンツソース（コピペして記事にしてください）</p><textarea style="width: 800px; height: 300px;">'.$ch_thread_data_html.'</textarea>';


echo '<p class="m_t_15 m_b_0">2ちゃんスレッドHTMLのCSS</p><textarea style="width: 800px; height: 200px;">
/******************************************
2ちゃんねるスレッドクラス

どんな形にもカスタマイズ出来るように
設計いたしました。
コピペしてCSSファイルに貼り付けお願いします。
*******************************************/
.ch_thread_design_1 {
	 margin: 0 0 15px;
}
.ch_thread_design_1 .comment {
	 margin: 0 0 15px;
}
.ch_thread_design_1 .comment .comment_data {

}
.ch_thread_design_1 .comment .comment_data span {
	color: #606060;
}
.ch_thread_design_1 .comment .comment_data .comment_number {

}
.ch_thread_design_1 .comment .comment_data .comment_name {
	color: #008000;
}
.ch_thread_design_1 .comment .comment_data .comment_time {
	color: #808080;
	font-size: 95%;
}
.ch_thread_design_1 .comment .comment_data .comment_id {
	color: #808080;
	font-size: 95%;
}
.ch_thread_design_1 .comment p {
    font-size: 105%;
    margin: 0 0 0 32px !important;
}
.m_0 {
  margin: 0 !important; }
</textarea>';
?>




<footer class="footer clear">
	<!-- コピーライト -->
	<section id="copy" style="padding-top: 15px; padding-bottom: 15px;">
		<p class="m_0">&copy; 2014 <a href="http://sharetube.jp/">Sharetube</a></p>
	</section>
</footer>
	</body>
</html>
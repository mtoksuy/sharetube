<?php



$ch_thread_content = '
3: ジャンピングカラテキック(チベット自治区)＠＼(^o^)／ 2015/08/06(木) 23:08:20.21 ID:zaWLh+tj0.net
母親バカかよｗｗｗ 
車で轢けよ

35: ドラゴンスクリュー(茸)＠＼(^o^)／ 2015/08/06(木) 23:14:00.91 ID:2RtDrABi0.net
>>3 
説得力あるな。

4: かかと落とし(庭)＠＼(^o^)／ 2015/08/06(木) 23:09:10.18 ID:/EtZAuWj0.net
全員死刑でいいよ

5: 膝靭帯固め(茸)＠＼(^o^)／ 2015/08/06(木) 23:09:17.11 ID:uemjxaOT0.net
さすがマッドシティの異名は伊達じゃないな

6: アトミックドロップ(京都府)＠＼(^o^)／ 2015/08/06(木) 23:09:17.58 ID:KJGbMvk50.net
なぜ母親の運転する車に乗って現場に来てんだ？ 
意味わからん

23: アルゼンチンバックブリーカー(愛知県)＠＼(^o^)／ 2015/08/06(木) 23:11:54.84 ID:/mhe8qxd0.net
>>6 
遊びに行くみたいな呼び出しだったんだろ。

50: ヒップアタック(東京都)＠＼(^o^)／ 2015/08/06(木) 23:16:42.72 ID:XJWWcG2a0.net
>>6 
保護者が居れば下手なことはされないと思ったのかもしれない

7: ウエスタンラリアット(栃木県)＠＼(^o^)／ 2015/08/06(木) 23:09:27.36 ID:uIW+/SF70.net
こういうのは殺しても世間が許すよ

8: ハーフネルソンスープレックス(兵庫県)＠＼(^o^)／ 2015/08/06(木) 23:09:28.20 ID:WEfq0qhZ0.net
松戸治安悪すぎw

9: 雪崩式ブレーンバスター(やわらか銀行)＠＼(^o^)／ 2015/08/06(木) 23:09:29.07 ID:aKKx8oug0.net
まーた松戸

10: サソリ固め(北海道)＠＼(^o^)／ 2015/08/06(木) 23:09:48.86 ID:tTFOc29GO.net
全治不明って久しぶりに聞いたわ

12: ダブルニードロップ(静岡県)＠＼(^o^)／ 2015/08/06(木) 23:10:09.86 ID:Nmb8T/hZ0.net
姉の怪我の理由が書いてないね

30: 急所攻撃(東京都)＠＼(^o^)／ 2015/08/06(木) 23:13:12.87 ID:PXJ7aPWO0.net
>>12 
察しろ 
裂傷で2週間の怪我だ

13: 目潰し(神奈川県)＠＼(^o^)／ 2015/08/06(木) 23:10:09.97 ID:4tbhbUKm0.net
タイか中国だと思ったら日本だった

14: ナガタロックII(京都府)＠＼(^o^)／ 2015/08/06(木) 23:10:10.52 ID:BETh2CWK0.net
し「まーくん、送って行くわよ」';
//--------------------------------
//ポストの中身をエンティティ化する
//--------------------------------
function post_security() {
	$post = array();
	foreach($_POST as $key => $value) {
		$post[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}
	return $post;
}
//------------------
//改行コード変換関数
//------------------
function convertEOL($string, $to = "\n") {   
	return preg_replace("/\r\n|\r|\n/", $to, $string);
}

$post = post_security();
$ch_thread_content = convertEOL($ch_thread_content);
$ch_thread_content .= '
';
$ch_thread_content_falf_html_chack = true;
var_dump($ch_thread_content);
/*
 3: ジャンピングカラテキック(チベット自治区)＠＼(^o^)／ 2015/08/06(木) 23:08:20.21 ID:zaWLh+tj0.net
母親バカかよｗｗｗ 
車で轢けよ
*/
$pattern_1 = "/([0-9]+\s：)(.*：)([0-9]{4}\/[0-9]{2}\/[0-9]{2}.{1,5}\s[0-9]{2}:[0-9]{2}:.+?)(\sID:.+)/"; // 新しい
$pattern_2 = "/([0-9]+:\s)(.*\s)([0-9]{4}\/[0-9]{2}\/[0-9]{2}.{1,5}\s[0-9]{2}:[0-9]{2}:.+?)(\sID:.+)/"; // 新しい
$pattern_3 = "/([0-9]+aaaaadfdf:\s)(.*\s)([0-9]{4}\/[0-9]{2}\/[0-9]{2}.{1,5}\s[0-9]{2}:[0-9]{2}:.+?)(\sID:.+)/"; // 新しい
$pattern_array = array($pattern_1, $pattern_2, $pattern_3);

// 換装HTML
$replacement = 		

'<div class="comment_data">
	<span class="comment_number">$1</span>
	<span class="comment_name">$2</span>
	<span class="comment_time">$3</span>
	<span class="comment_id">$4</span>
</div>';

//$ch_thread_content_falf_html = preg_replace($pattern, $replacement, $ch_thread_content);



foreach($pattern_array as $key => $value) {
	if($ch_thread_content_falf_html_chack) {
		if(preg_match_all($value, $ch_thread_content, $ch_thread_content_array)) {
			$ch_thread_content_falf_html = preg_replace($value, $replacement, $ch_thread_content);
			$ch_thread_content_falf_html_chack = false;
		}
	}
}
print_r($ch_thread_content_falf_html);




?>
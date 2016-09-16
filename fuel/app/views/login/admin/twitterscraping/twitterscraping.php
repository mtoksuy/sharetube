<?php 
//var_dump($_POST);
$subject = $tweet_url = $_POST["tweet_url"];


// 改行コード\nへ変換
$subject = str_replace("\r\n", "\n", $subject);
$subject = str_replace("\r", "\n", $subject);
$subject = str_replace(" ", "\n", $subject);
$subject = str_replace("　", "\n", $subject);
$subject = str_replace(",", "\n", $subject);
$subject = str_replace("、", "\n", $subject);
// 末に改行を追加
$subject .= "\n";
//var_dump($subject);


$pattern = '/https:\/\/(.+?)status\/(.+?)\n/';
preg_match_all($pattern, $subject, $tweet_url_array);
// 改行削除
$tweet_url_array[0] = str_replace("\n", "", $tweet_url_array[0]);


// tweetスクレイピング&HTML生成
foreach($tweet_url_array[0] as $key => $value) {
	// なぜか本番でしかスクレイピングできないからミラーソースコードでテスト
//	$tweet_data_array  = Model_Login_Twitterscraping_Mirror_Basis::Twitter_scraping($value); 直った 2016.09.16 松岡

	$tweet_data_array  = Model_Login_Twitterscraping_Basis::Twitter_scraping($value);
	$tweet_html       .= Model_Login_Twitterscraping_Html::tweet_html_create($tweet_data_array);
}
?>

<h1>Twitter・Tweet埋め込みツール Var.1.02</h1>

<p>公式のTweet埋め込みだと問題が多々あると感じ（SEO面とTweetを削除された場合）自作でTweet埋め込みツールを内部リリース致しました。アップデートなどの要望、ご連絡は<a href="http://sharetube.jp/" target="_blank">Sharetube</a>にあるコンタクトか、僕のTwitterアカウント<a href="https://twitter.com/mtoksuy" target="_blank">@mtoksuy</a>へ宜しくお願い致します。</p>


<h4 class="m_t_30 m_b_15">更新情報</h4>
<p>2015年04月01日：Var.1.00リリース</p>

<p class="m_0">2015年04月02日：Var.1.01</p>
<p>・articleカードなどが含まれているとvideo判定が立つバグ応急処置(根本的には直ってはいない)</p>

<p class="m_0">2015年04月03日：Var.1.02</p>
<p class="m_0">・文脈のあるツイートで生成すると他の文言を取得してしまうバグ修正</p>
<p class="m_0">・リプライした時に相手名前（@aaaなど）へリンクを貼るよう修正</p>
<p class="m_0">・内部実装でDomノードを取得できるよう修正</p>
<p class="m_0">・その他細かいバグ修正</p>

<!--
次回アップデートメモ

<div class="permalink-container">
・コンテンツ全体

<div class="permalink-inner permalink-tweet-container">
・主コンテンツ




〜ストリーム・リプライ系〜
<div id="ancestors">
うえ
	<ol id="stream-items-id" class="stream-items js-navigable-stream">
		<li class="js-simple-tweet">
		<li class="js-simple-tweet">
		<li class="js-simple-tweet">


した
<div id="descendants">
	<ol id="stream-items-id" class="stream-items js-navigable-stream">
		<li class="js-simple-tweet">
		<li class="js-simple-tweet">
		<li class="js-simple-tweet">
-->




<h2 class="heading_4">使い方・仕様</h2>

<div class="tweet">
			<div class="tweet_content">
				<div class="tweet_content_icon">
					<a target="_blank" href="https://twitter.com/mtoksuy">
						<img width="48" height="48" src="https://pbs.twimg.com/profile_images/3581136395/681012dbf467c57041a28b07536deaa2_bigger.png">
					</a>
				</div>
				<div class="tweet_content_name">
					<a target="_blank" href="https://twitter.com/mtoksuy">
						<b>マツオカソウヤ</b>
						<span>@mtoksuy</span>
					</a>
				</div>
				<div class="tweet_content_text">
					tweet埋め込みツール完成致しました<br><br>おそらくネイバーまとめで使用できるtweet埋め込みツールより、性能が高いです。<br><br>jpg、png、gif、動画 完全対応。<br>レスポンシブで全デバイス対応。<br>ペロペロなデザイン。<br>デザインはcssでカスタマイズ可能。
				</div>
				
				
				
				<div class="tweet_content_action clearfix">
					<div class="tweet_content_action_reply">
						<a data-tw-params="true" href="https://twitter.com/intent/tweet?in_reply_to=583193602890735616" class="reply-action web-intent" title="返信" data-scribe="element:reply">
							<span class="typcn typcn-arrow-back"></span>
						</a>
					</div>
					<div class="tweet_content_action_retweet">
						<a data-tw-params="true" href="https://twitter.com/intent/retweet?tweet_id=583193602890735616" class="retweet-action web-intent" title="リツイート" data-scribe="element:retweet">
							<span class="typcn typcn-arrow-repeat">1</span>
						</a>
					</div>
					<div class="tweet_content_action_fav">
						<a href="https://twitter.com/intent/favorite?tweet_id=583193602890735616" class="favorite-action web-intent" title="お気に入り" data-scribe="element:favorite">
							<span class="typcn typcn-star-full-outline">0</span>
						</a>
					</div>
					<div class="tweet_content_time">
						<a target="_blank" href="https://twitter.com/mtoksuy/status/583193602890735616">
							2015年04月01日 18:06:04
						</a>
					</div>
				</div>
			</div>
		</div>

<p>・埋め込みHTML生成も一つではなく複数URLを一気に変換できる。</p>
<p>・コピペしたTweetURLとTweetURの間は「改行」、「半角空白」、「全角空白」、「,」、「、」に対応。</p>
<div class="tweet">
			<div class="tweet_content">
				<div class="tweet_content_icon">
					<a target="_blank" href="https://twitter.com/mtoksuy">
						<img width="48" height="48" src="https://pbs.twimg.com/profile_images/3581136395/681012dbf467c57041a28b07536deaa2_bigger.png">
					</a>
				</div>
				<div class="tweet_content_name">
					<a target="_blank" href="https://twitter.com/mtoksuy">
						<b>マツオカソウヤ</b>
						<span>@mtoksuy</span>
					</a>
				</div>
				<div class="tweet_content_text">
					tweetを消されてもコンテンツ(画像など)は消えません。<br>専用サーバにコンテンツをコピーしており、そのコンテンツを参照する仕様にしました。<br><br>公式が提供している埋め込みはtweetが消されるとコンテンツも呼び出しが出来ずデザインも崩れて、ブログで使用するには難しいものでした。
				</div>
				
				
				
				<div class="tweet_content_action clearfix">
					<div class="tweet_content_action_reply">
						<a data-tw-params="true" href="https://twitter.com/intent/tweet?in_reply_to=583194352689659904" class="reply-action web-intent" title="返信" data-scribe="element:reply">
							<span class="typcn typcn-arrow-back"></span>
						</a>
					</div>
					<div class="tweet_content_action_retweet">
						<a data-tw-params="true" href="https://twitter.com/intent/retweet?tweet_id=583194352689659904" class="retweet-action web-intent" title="リツイート" data-scribe="element:retweet">
							<span class="typcn typcn-arrow-repeat">1</span>
						</a>
					</div>
					<div class="tweet_content_action_fav">
						<a href="https://twitter.com/intent/favorite?tweet_id=583194352689659904" class="favorite-action web-intent" title="お気に入り" data-scribe="element:favorite">
							<span class="typcn typcn-star-full-outline">0</span>
						</a>
					</div>
					<div class="tweet_content_time">
						<a target="_blank" href="https://twitter.com/mtoksuy/status/583194352689659904">
							2015年04月01日 18:09:03
						</a>
					</div>
				</div>
			</div>
		</div>



<h2 class="heading_4">Tweet埋め込みHTML生成</h2>
<form class="" action="" method="post">
	<textarea name="tweet_url" style="    border: 1px solid #777777;
    border-radius: 3px;
    height: 200px;
    width: 500px;"></textarea>
	<input type="submit" name="submit" style="    background-color: #55acee;
    border: 0 solid #313131;
    border-radius: 3px;
    color: #474747;
    cursor: pointer;
    display: block;
    font-weight: bold;
    margin: 0 0 15px;
    padding: 10px 15px;" value="Tweet埋め込みHTML生成">
</form>



<?php
	echo($tweet_html);
?>



<p class="m_0">生成されたコンテンツソース（コピペして記事にペースト）</p>




<textarea style="    border: 1px solid #777777;
    border-radius: 3px;
    height: 800px;
    width: 70%;">
<?php
	echo($tweet_html);
?>
</textarea>






		<div class="tweet">
			<div class="tweet_content">
				<div class="tweet_content_icon">
					<a href="https://twitter.com/mtoksuy" target="_blank">
						<img src="http://sharetube.jp/assets/img/twitter/6555_tsD.png" width="48" height="48">
					</a>
				</div>
				<div class="tweet_content_name">
					<a href="https://twitter.com/mtoksuy" target="_blank">
						<b>マツオカソウヤ</b>
						<span>@mtoksuy</span>
					</a>
				</div>
				<div class="tweet_content_text">
					はっ恥ずかしいところ<br>撮らないでニャン/// <a href="http://t.co/3CUg5rHRDv" class="twitter-timeline-link u-hidden" data-pre-embedded="true" dir="ltr">pic.twitter.com/3CUg5rHRDv</a>
				</div>
				<div class="image_media_1">
							<div class="great_image_set_50 tweet_image_media">
								<p class="m_0">
									<a href="http://sharetube.jp/assets/img/twitter/6556_usD.jpg" target="_blank">
										<img width="640" height="400" title="" alt="" src="http://sharetube.jp/assets/img/twitter/6556_usD.jpg" class="o_8">
									</a>
								</p>
							</div>
						</div>
				
				
				<div class="tweet_content_action clearfix">
					<div class="tweet_content_action_reply">
						<a data-scribe="element:reply" title="返信" class="reply-action web-intent" href="https://twitter.com/intent/tweet?in_reply_to=582452544678465536" data-tw-params="true">
							<span class="typcn typcn-arrow-back"></span>
						</a>
					</div>
					<div class="tweet_content_action_retweet">
						<a data-scribe="element:retweet" title="リツイート" class="retweet-action web-intent" href="https://twitter.com/intent/retweet?tweet_id=582452544678465536" data-tw-params="true">
							<span class="typcn typcn-arrow-repeat">1</span>
						</a>
					</div>
					<div class="tweet_content_action_fav">
						<a data-scribe="element:favorite" title="お気に入り" class="favorite-action web-intent" href="https://twitter.com/intent/favorite?tweet_id=582452544678465536">
							<span class="typcn typcn-star-full-outline">0</span>
						</a>
					</div>
					<div class="tweet_content_time">
						<a href="https://twitter.com/mtoksuy/status/582452544678465536" target="_blank">
							2015年03月30日 17:01:22
						</a>
					</div>
				</div>
			</div>
		</div>





<footer class="footer clear">
	<!-- コピーライト -->
	<section id="copy" style="padding-top: 15px; padding-bottom: 15px;">
		<p class="m_0">&copy; 2014 <a href="http://sharetube.jp/">Sharetube</a></p>
	</section>
</footer>
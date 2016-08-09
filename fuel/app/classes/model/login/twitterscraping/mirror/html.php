<?php 
class Model_Login_Twitterscraping_Html extends Model {
	//----------------
	//ツイートHTML生成
	//----------------
	static function tweet_html_create($tweet_data_array) {
		$twitter_url = 'https://twitter.com/';
		// 画像メディアHTML生成
		$image_media_html = Model_Login_Twitterscraping_Html::image_media_html_create($tweet_data_array);
		// gifメディアHTML生成
		$gif_media_html   = Model_Login_Twitterscraping_Html::gif_media_html_create($tweet_data_array);
		// videoメディアHTML生成
		$video_media_html = Model_Login_Twitterscraping_Html::video_media_html_create($tweet_data_array);



//var_dump($tweet_data_array['text']);
// 改行を<br>に変換
$tweet_data_array['text'] = str_replace("\n", "<br>", $tweet_data_array['text']);
$tweet_data_array['text'] = str_replace("&#10;", "<br>", $tweet_data_array['text']);
//var_dump($tweet_data_array['text']);
		$tweet_html = '
		<div class="tweet">
			<div class="tweet_content">
				<div class="tweet_content_icon">
					<a href="'.$twitter_url.$tweet_data_array["id"].'" target="_blank">
						<img src="'.HTTP.'assets/img/twitter/'.$tweet_data_array['icon'].'" width="48" height="48">
					</a>
				</div>
				<div class="tweet_content_name">
					<a href="'.$twitter_url.$tweet_data_array["id"].'" target="_blank">
						<b>'.$tweet_data_array['name'].'</b>
						<span>@'.$tweet_data_array['id'].'</span>
					</a>
				</div>
				<div class="tweet_content_text">
					'.$tweet_data_array['text'].'
				</div>
				'.$image_media_html.'
				'.$gif_media_html.'
				'.$video_media_html.'
				<div class="tweet_content_action clearfix">
					<div class="tweet_content_action_reply">
						<a data-scribe="element:reply" title="返信" class="reply-action web-intent" href="https://twitter.com/intent/tweet?in_reply_to='.$tweet_data_array["tweet_id"].'" data-tw-params="true">
							<span class="typcn typcn-arrow-back"></span>
						</a>
					</div>
					<div class="tweet_content_action_retweet">
						<a data-scribe="element:retweet" title="リツイート" class="retweet-action web-intent" href="https://twitter.com/intent/retweet?tweet_id='.$tweet_data_array["tweet_id"].'" data-tw-params="true">
							<span class="typcn typcn-arrow-repeat">'.$tweet_data_array["retweet"].'</span>
						</a>
					</div>
					<div class="tweet_content_action_fav">
						<a data-scribe="element:favorite" title="お気に入り" class="favorite-action web-intent" href="https://twitter.com/intent/favorite?tweet_id='.$tweet_data_array["tweet_id"].'">
							<span class="typcn typcn-star-full-outline">'.$tweet_data_array["fav"].'</span>
						</a>
					</div>
					<div class="tweet_content_time">
						<a href="'.$twitter_url.$tweet_data_array["id"].'/status/'.$tweet_data_array["tweet_id"].'" target="_blank">
							'.$tweet_data_array["time"].'
						</a>
					</div>
				</div>
			</div>
		</div>';
		return $tweet_html;
	}
	//--------------------
	//画像メディアHTML生成
	//--------------------
	static function image_media_html_create($tweet_data_array) {
		$image_count = 0;
		$image_media_html = '';
		// 画像メディアの数を調べる
		foreach($tweet_data_array["image_media_run"] as $key => $value) {
			$image_count++;
		}
		// 画像の数によって挙動を変える
		switch($image_count) {
			///////////////
			//1枚だけの場合
			///////////////
			case 1:
				foreach($tweet_data_array["image_media_run"] as $key => $value) {
					$image_media_html .= 
						'<div class="image_media_1">
							<div class="great_image_set_50 tweet_image_media">
								<p class="m_0">
									<a href="'.HTTP.'assets/img/twitter/'.$value.'" target="_blank">
										<img width="640" height="400" title="" alt="" src="'.HTTP.'assets/img/twitter/'.$value.'" class="o_8">
									</a>
								</p>
							</div>
						</div>';
				}				
			break;
			///////////////
			//2枚だけの場合
			///////////////
			case 2:
				foreach($tweet_data_array["image_media_run"] as $key => $value) {
					// 画像サイズ取得
					list($width, $height) = getimagesize(HTTP.'assets/img/twitter/'.$value);
							$image_media_html .= 
								'<div class="great_image_set_100 tweet_image_media">
									<p class="m_0">
										<a href="'.HTTP.'assets/img/twitter/'.$value.'" target="_blank">
											<img width="'.$width.'" height="'.$height.'" title="" alt="" src="'.HTTP.'assets/img/twitter/'.$value.'" class="o_8">
										</a>
									</p>
								</div>';
				}
				$image_media_html = 
					'<div class="image_media_2">
						<div class="image_media_2_top">
							'.$image_media_html.'
						</div>
					</div>';
			break;
			///////////////
			//3枚だけの場合
			///////////////
			case 3:

			break;
			///////////////
			//4枚だけの場合
			///////////////
			case 4:
				foreach($tweet_data_array["image_media_run"] as $key => $value) {
					switch($image_count) {
						case 1:
							$image_media_html .= 
								'<div class="great_image_set_100 tweet_image_media">
									<p class="m_0">
										<a href="'.HTTP.'assets/img/twitter/'.$value.'" target="_blank">
											<img width="640" height="400" title="" alt="" src="'.HTTP.'assets/img/twitter/'.$value.'" class="o_8">
										</a>
									</p>
								</div>
							</div>';
						break;
						case 2:
							$image_media_html .= 
								'<div class="image_media_4_bottom">
									<div class="great_image_set_100 tweet_image_media">
										<p class="m_0">
											<a href="'.HTTP.'assets/img/twitter/'.$value.'" target="_blank">
												<img width="640" height="400" title="" alt="" src="'.HTTP.'assets/img/twitter/'.$value.'" class="o_8">
											</a>
										</p>
									</div>';
						break;
						case 3:
							$image_media_html .= 
								'<div class="great_image_set_100 tweet_image_media">
									<p class="m_0">
										<a href="'.HTTP.'assets/img/twitter/'.$value.'" target="_blank">
											<img width="640" height="400" title="" alt="" src="'.HTTP.'assets/img/twitter/'.$value.'" class="o_8">
										</a>
									</p>
								</div>
							</div>';
						break;
						case 4:
							$image_media_html .= 
								'<div class="image_media_4_top">
									<div class="great_image_set_100 tweet_image_media">
										<p class="m_0">
											<a href="'.HTTP.'assets/img/twitter/'.$value.'" target="_blank">
												<img width="640" height="400" title="" alt="" src="'.HTTP.'assets/img/twitter/'.$value.'" class="o_8">
											</a>
										</p>
									</div>';
						break;
						default:

						break;
					}
					$image_count--;
				}
				$image_media_html = 
					'<div class="image_media_4">
						'.$image_media_html.'
					</div>';
			break;
			///////////////
			//4枚以上の場合
			///////////////
			default:
				foreach($tweet_data_array["image_media_run"] as $key => $value) {
					switch($image_count) {
						case 1:
							$image_media_html .= 
								'<div class="great_image_set_100 tweet_image_media">
									<p class="m_0">
										<a href="'.HTTP.'assets/img/twitter/'.$value.'" target="_blank">
											<img width="640" height="400" title="" alt="" src="'.HTTP.'assets/img/twitter/'.$value.'" class="o_8">
										</a>
									</p>
								</div>
							</div>';
						break;
						case 2:
							$image_media_html .= 
								'<div class="image_media_4_bottom">
									<div class="great_image_set_100 tweet_image_media">
										<p class="m_0">
											<a href="'.HTTP.'assets/img/twitter/'.$value.'" target="_blank">
												<img width="640" height="400" title="" alt="" src="'.HTTP.'assets/img/twitter/'.$value.'" class="o_8">
											</a>
										</p>
									</div>';
						break;
						case 3:
							$image_media_html .= 
								'<div class="great_image_set_100 tweet_image_media">
									<p class="m_0">
										<a href="'.HTTP.'assets/img/twitter/'.$value.'" target="_blank">
											<img width="640" height="400" title="" alt="" src="'.HTTP.'assets/img/twitter/'.$value.'" class="o_8">
										</a>
									</p>
								</div>
							</div>';
						break;
						case 4:
							$image_media_html .= 
								'<div class="image_media_4_top">
									<div class="great_image_set_100 tweet_image_media">
										<p class="m_0">
											<a href="'.HTTP.'assets/img/twitter/'.$value.'" target="_blank">
												<img width="640" height="400" title="" alt="" src="'.HTTP.'assets/img/twitter/'.$value.'" class="o_8">
											</a>
										</p>
									</div>';
						break;
						default:

						break;
					}
					$image_count--;
				}
				// 合体
				$image_media_html = 
					'<div class="image_media_4">
						'.$image_media_html.'
					</div>';
			break;
		}
		// 画像がなかった場合初期化
		if(!$tweet_data_array["image_media_run"]) {
			$image_media_html = '';
		}
		return $image_media_html;
	}
	//-------------------
	//gifメディアHTML生成
	//-------------------
	static function gif_media_html_create($tweet_data_array) {
		$gif_media_html = '';
		foreach($tweet_data_array["gif_media_run"] as $key => $value) {
		$gif_media_html .= 
		'<video loop autoplay poster="'.HTTP.'assets/img/twitter/'.$tweet_data_array["gif_media_thumbnail_run"][0].'">
			<source src="'.HTTP.'assets/img/twitter/'.$value.'"></source>
			<p>ご利用のブラウザーでは再生できません。</p>
		</video>';
		}
		// 合体
		$gif_media_html = 
		'<div class="gif_media">
			'.$gif_media_html.'
		</div>';
		// gifがなかった場合初期化
		if(!$tweet_data_array["gif_media_run"]) {
			$gif_media_html = '';
		}
		return $gif_media_html;
	}
	//---------------------
	//videoメディアHTML生成
	//---------------------
	static function video_media_html_create($tweet_data_array) {
		$video_media_html = '';
		foreach($tweet_data_array["video_media_run"] as $key => $value) {
		$video_media_html .= 
		'<video controls poster="'.HTTP.'assets/img/twitter/'.$tweet_data_array["video_media_thumbnail_run"][0].'">
			<source src="'.HTTP.'assets/img/twitter/'.$value.'"></source>
			<p>ご利用のブラウザーでは再生できません。</p>
		</video>';
		}
		// 合体
		$video_media_html = 
		'<div class="video_media">
			'.$video_media_html.'
		</div>';
		// videoがなかった場合初期化
		if(!$tweet_data_array["video_media_run"]) {
			$video_media_html = '';
		}
		return $video_media_html;
	}
}

<?php
/*
* 
* 検索HTML関連クラス
* 
* 
* 
*/

class Model_Search_Html extends Model {
	//----------------
	//
	//----------------
	static function search_html_create($search_res) {
		// 変数
		$article_list_html_array = array();
		$article_list_html       = '';
		$i                       = 0;
		$article_type            = 'article';
		// 記事一覧HTML生成
		foreach($search_res as $key => $value) {
			// 記事データ取得
			$article_author       = $value["sharetube_id"];
			$unix_time            = strtotime($value["create_time"]);
			$local_time           = date('Y-m-d', $unix_time);
			$local_japanese_time  = date('Y年m月d日', $unix_time);
			$article_year_time    = date('Y', $unix_time);

			// 改行を消す&タブ削除
			$article_contests = str_replace(array("\r\n", "\r", "\n", "\t"), '', $value["sub_text"].$value["text"]);
			// 本文を5680文字に丸める
			$article_contests = mb_strimwidth($article_contests, 0, 5680, "...", 'utf8'); // 応急処置 2018.01.31 なぜこれで直るかはわからん 下記のpreg_replaceが重すぎた
			// HTMLタグを取り除く
			$article_contests = preg_replace('/<("[^"]*"|\'[^\']*\'|[^\'">])*>/', '', $article_contests);
			// 本文を168文字に丸める
			$summary_contents = mb_strimwidth($article_contests, 0, 168, "...", 'utf8');

			// エンティティを戻す
			$title        = htmlspecialchars_decode($value["title"], ENT_NOQUOTES);
			// カテゴリー情報取得
			$category_info_array = Model_Info_Basis::category_info_get($value["category"]);
			// ターゲット画像
			$targetImage = (PATH.'assets/img/'.$article_type.'/'.$article_year_time.'/detail/'.$value["thumbnail_image"]);
			// コピー元画像のファイルサイズを取得
			list($image_w, $image_h) = getimagesize($targetImage);
			// ターゲット画像
			$targetImage = (PATH.'assets/img/'.$article_type.'/'.$article_year_time.'/facebook_ogp/'.$value["thumbnail_image"]);
			// コピー元画像のファイルサイズを取得
			list($image_w, $image_h) = getimagesize($targetImage);
				$image_reito = ($image_h / $image_w);
				$new_image_h = (int)(200 * $image_reito);
			// シェアボタンでエンコードして使う
			$encode_link           = (''.HTTP.''.$article_type.'/'.$value["link"].'/');
			// ソーシャルシェアボタンHTMl生成
			$social_share_html = Model_Article_Html::social_share_html_create($encode_link, $value, $article_type);
			// 記事一覧HTMLarry生成
			$article_list_html_array[$i] = ('
					<li class="o_8">
						<article data-article_number="'.$value["primary_id"].'" data-article_year="'.$article_year_time.'">
							<a class="clearfix" href="'.HTTP.''.$article_type.'/'.$value["link"].'/">
								<div class="card_article_contents clearfix">
									<h1>'.$value["title"].'</h1>
									<div class="card_article_contents_summary">'.$summary_contents.'</div>
									<div class="card_article_contents_time">'.$local_time.'</div>
								</div>
								<figure>
									<img class="" src="'.HTTP.'assets/img/'.$article_type.'/'.$article_year_time.'/facebook_ogp/'.$value["thumbnail_image"].'" width="200" height="'.$new_image_h.'" title="'.$value["title"].'" alt="'.$value["title"].'">
								</figure>
								<div class="category_band '.$category_info_array["category_color"].'">'.$value["category"].'</div>
							</a>
						</article>
					</li>');
			$i++;
		}
		// 記事一覧HTML合体
		foreach($article_list_html_array as $key => $value) {
			$article_list_html .= $value;
		}
		// 空なら空で返す
		if(!$article_list_html == '') {
			$article_list_html = ('
				<div class="card_article">
					<div class="card_article_content">

							<h3>検索結果： '.$i.'件</h3>

						<ul class="clearfix">
							'.$article_list_html.'
						</ul>
					</div>
				</div>');
		}
		$search_html = $article_list_html;
		return $search_html;
	}
}
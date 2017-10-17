<?php 

/**
 * 削除リストHtml関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Matome_Delete_Html extends Model {
	//----------------------------------
	//自分が書いた下書きのリストhtml生成
	//----------------------------------
	static function delete_article_list_html_create($delete_article_list_get_res) {
		foreach($delete_article_list_get_res as $key => $value) {
//			var_dump($value);
		$unix_time         = strtotime($value["create_time"]);
		$now_date          = date('Y-m-d', $unix_time);
		$create_date       = date('Y-m-d H:i:s', $unix_time);
		$article_year_time = date('Y', $unix_time);

//pre_var_dump($value);
		// 緊急策 松岡
		$random_key_year = (int)substr($value['random_key'], 0, 4);
		$random_key_year = (int)$create_date;

			$article_list_html .= '
				<div class="article_list_content">
					<div class="article_list_content_"><b>No：</b>'.$value["primary_id"].'</div>
					<div class="article_list_content_"><b>タイトル：</b>'.$value["title"].'</div>
					<div class="article_list_content_"><b>サムネ：</b>
					</div>
					<img width="200" height="105" src="'.HTTP.'assets/img/article/'.$random_key_year.'/facebook_ogp_half/'.$value["thumbnail_image"].'">
					<div class="article_list_content_edit">
						<ul class="clearfix">
							<li><a target="_blank" href="'.HTTP.'login/admin/matome/delete/edit/'.$value["primary_id"].'/">再編集する</a></li>
							<li><a href="'.HTTP.'login/admin/matome/delete/preview/?p='.$value["primary_id"].'" target="_blank">確認する</a></li>
							<li style="float: right;"><a href="'.HTTP.'login/admin/matome/delete/delete/'.$value["primary_id"].'/">本当に削除する</a></li>
						</ul>
					</div>
				</div>';
//				<div class="article_list_content"></div>
		}
		return $article_list_html;
	}
}

<?php 
class Model_Login_List_Html extends Model {
	//--------------------------------
	//自分が書いた記事のリストhtml生成
	//--------------------------------
	static function article_list_html_create($article_list_get_res) {
		foreach($article_list_get_res as $key => $value) {
		$unix_time         = strtotime($value["create_time"]);
		$now_date          = date('Y-m-d', $unix_time);
		$create_date       = date('Y-m-d H:i:s', $unix_time);
		$article_year_time = date('Y', $unix_time);

/*
	以前の編集URL 2015.06.13 松岡
							<li><a href="'.HTTP.'login/admin/list/edit/'.$value["primary_id"].'/">編集する</a></li>
*/
			$article_list_html .= '
				<div class="article_list_content">
					<div class="article_list_content_"><b>No：</b>'.$value["primary_id"].'</div>
					<div class="article_list_content_"><b>タイトル：</b>'.$value["title"].'</div>
					<div class="article_list_content_"><b>サムネ：</b>
					</div>
					<img width="200" height="105" src="'.HTTP.'assets/img/article/'.$article_year_time.'/facebook_ogp_half/'.$value["thumbnail_image"].'">
					<div class="article_list_content_edit">
						<ul class="clearfix">
							<li><a target="_blank" href="'.HTTP.'login/admin/matome/edit/'.$value["primary_id"].'/">編集する</a></li>
							<li><a href="'.HTTP.'article/'.$value["link"].'/" target="_blank">確認する</a></li>
							<li class="article_delete_button" style="float: right;"><a data-href="'.HTTP.'login/admin/list/delete/'.$value["primary_id"].'/">削除する</a></li>
						</ul>
					</div>
				</div>';
//				<div class="article_list_content"></div>
		}
		return $article_list_html;
	}
}

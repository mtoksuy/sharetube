<?php
/*
* 
* キュレーターリストHTML関連クラス
* 
* 
* 
*/

class Model_Curatorlist_Html extends Model {
	//--------------------------
	//キュレーターリストHTML生成
	//--------------------------
	public static function curator_list_html_create($curator_list_res) {


		foreach($curator_list_res as $key => $value) {
			$count_res = DB::query("
				SELECT COUNT(sharetube_id)
				FROM article
				WHERE
					sharetube_id = '".$value['sharetube_id']."'
					AND del = 0")->cached(900)->execute();
				foreach($count_res as $count_key => $count_value) {

				}
			$curator_list_li_html .= 
				'<li class="curator_list_li">
					<div class="curator_data clearfix">
						<div class="curator_icon">
							<a href="'.HTTP.'channel/'.$value['sharetube_id'].'/" class="o_8">
								<img width="128" height="128" src="'.HTTP.'assets/img/creators/icon/'.$value['profile_icon'].'" alt="'.$value['name'].'" title="'.$value['name'].'">
							</a>
						</div>
						<ol class="curator_matome_data">
							<li class="curator_matome_number">
								<span class="summary">'.$count_value['COUNT(sharetube_id)'].'</span>
								<span class="word">まとめ作成数</span>
							</li>
							<li class="curator_page_data">
								<span class="summary">'.$value['all_page_view'].'</span>
								<span class="word">総ページビュー</span>
							</li>
						</ol>
					</div>
					<div class="curator_name">
						'.$value['name'].'
					</div>
					<div class="curator_">
						<p class="m_0">'.$value['profile_contents'].'</p>
					</div>
				</li>';
		}
			// 合体
			$curator_list_html .= 
				'<div class="curator_list">
					<div class="curator_list_inner">
						<div class="curator_list_title">
							<span class="typcn typcn-document-text"></span><span>キュレーターリスト</span>
						</div>
						<ol class="curator_list_ol">
							'.$curator_list_li_html.'
						</ol>
					</div>
				</div>';
		return $curator_list_html;
	}
}












<?php 
/*
* 
* キュレーターリストBasisクラス
* 
* 
* 
*/

class Model_Curatorlist_Basis extends Model {
	//-------------------------
	//キュレーターリストres取得
	//-------------------------
	public static function curatorlist_res_get() {
		$curator_list_res = DB::query("
			SELECT sharetube_id, name, profile_contents, profile_icon, all_page_view
			FROM user
					WHERE all_page_view > 1
			ORDER BY all_page_view DESC")->cached(900)->execute();
		return $curator_list_res;
	}
}

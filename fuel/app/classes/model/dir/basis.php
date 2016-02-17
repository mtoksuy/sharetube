<?php
/**
 * ディレクトリ関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Dir_Basis extends Model {
	//------------------------------
	//サムネイルディレクトリ自動生成
	//------------------------------
	static function thumbnail_dir_create($create_dir, $article_year_time) {
		// ディレクトリを作る場所
		// 親
		$year_dir                   = (PATH.'assets/img/'.$create_dir.'/'.$article_year_time."/");
		// 子
		$detail_dir                 = (PATH.'assets/img/'.$create_dir.'/'.$article_year_time."/detail/");
		$facebook_ogp_dir           = (PATH.'assets/img/'.$create_dir.'/'.$article_year_time."/facebook_ogp/");
		$facebook_ogp_half_dir      = (PATH.'assets/img/'.$create_dir.'/'.$article_year_time."/facebook_ogp_half/");
		$facebook_ogp_half_half_dir = (PATH.'assets/img/'.$create_dir.'/'.$article_year_time."/facebook_ogp_half_half/");
		$facebook_ogp_reseve_dir    = (PATH.'assets/img/'.$create_dir.'/'.$article_year_time."/facebook_ogp_reseve/");
		$original_dir               = (PATH.'assets/img/'.$create_dir.'/'.$article_year_time."/original/");
		$square_dir                 = (PATH.'assets/img/'.$create_dir.'/'.$article_year_time."/square/");
		$square_200px_dir           = (PATH.'assets/img/'.$create_dir.'/'.$article_year_time."/square_200px/");
		$square_120px_dir           = (PATH.'assets/img/'.$create_dir.'/'.$article_year_time."/square_120px/");
		$thumbnail_dir              = (PATH.'assets/img/'.$create_dir.'/'.$article_year_time."/thumbnail/");
		//				var_dump($year_dir);
		// ディレクトリが存在するかチェックし、なければ作成
		if(!is_dir($year_dir)) {
			// 必要らしい
			umask(0);
			// ディレクトリ作成
			$rc   = mkdir($year_dir, 0777);
			$rc   = mkdir($detail_dir, 0777);
			$rc   = mkdir($facebook_ogp_dir, 0777);
			$rc   = mkdir($facebook_ogp_half_dir, 0777);
			$rc   = mkdir($facebook_ogp_half_half_dir, 0777);
			$rc   = mkdir($facebook_ogp_reseve_dir, 0777);
			$rc   = mkdir($original_dir, 0777);
			$rc   = mkdir($square_dir, 0777);
			$rc   = mkdir($square_200px_dir, 0777);
			$rc   = mkdir($square_120px_dir, 0777);
			$rc   = mkdir($thumbnail_dir, 0777);
		}
	}
	//------------------------------
	//ディレクトリのファイル一覧取得
	//------------------------------
	static function getFileList($dir) {
		$files = glob(rtrim($dir, '/') . '/*');
		$list  = array();
		foreach ($files as $file) {
			if (is_file($file)) {
				$list[] = $file;
			}
			if (is_dir($file)) {
				$list = array_merge($list, getFileList($file));
			}
		}
		return $list;
	}
}
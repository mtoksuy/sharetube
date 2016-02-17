<?php 

/**
 * ポスト・下書き関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Post_Draft_Basis extends Model {
	//--------------
	//記事下書き保存
	//--------------
	static function article_draft_save($article_create_data_array, $matome_frg = false) {
		// カテゴリー情報取得
		$category_info_array = Model_Info_Basis::category_info_get($article_create_data_array["category"]);
		if($matome_frg) {
			$article_create_data_array["matome_frg"] = 1;
		}
			else {
				$article_create_data_array["matome_frg"] = 0;
			}
		// 下書き登録
		 $draft_primary_id_array = DB::query(
			"INSERT INTO draft (
				sharetube_id ,
				category ,
				title ,
				sub_text,
				contents ,
				text, 
				tag ,
				original,
				thumbnail_image ,
				sp_thumbnail , 
				link ,
				random_key,
				matome_frg, 
				update_time
			)
			VALUES (
				'".$article_create_data_array["sharetube_id"]."',
				'".$category_info_array["category_name"]."',
				'".$article_create_data_array["title"]."',
				'".$article_create_data_array["sub_text"]."',
				'".$article_create_data_array["contents"]."',
				'".$article_create_data_array["text"]."',
				'".$article_create_data_array["tag"]."',
				'".$article_create_data_array["original"]."',
				'".$article_create_data_array["thumbnail_image"]."',
				".$article_create_data_array["sp_thumbnail"].", 
				'".$article_create_data_array["link"]."',
				'".$article_create_data_array["random_key"]."',
				'".$article_create_data_array["matome_frg"]."',
				'".$article_create_data_array["create_date"]."')")->execute();
				$draft_primary_id = $draft_primary_id_array[0];

//				var_dump($draft_primary_id_array);


			return $draft_primary_id;
	}
	//--------------
	//記事下書き更新
	//--------------
	static function article_draft_update($article_create_data_array) {
//		var_dump($article_create_data_array);
		DB::query("
			UPDATE draft SET
				category        = '".$article_create_data_array["category"]."' ,
				title           = '".$article_create_data_array["title"]."' ,
				sub_text        = '".$article_create_data_array["sub_text"]."' ,
				contents        = '".$article_create_data_array["contents"]."' ,
				text            = '".$article_create_data_array["text"]."' ,
				tag             = '".$article_create_data_array["tag"]."' ,
				original        = '".$article_create_data_array["original"]."' ,
				thumbnail_image = '".$article_create_data_array["thumbnail_image"]."' ,
				sp_thumbnail    = '".$article_create_data_array["sp_thumbnail"]."' , 
				link            = '".$article_create_data_array["link"]."' ,
				random_key      = '".$article_create_data_array["random_key"]."' ,
				update_time     = '".$article_create_data_array["create_date"]."'
			WHERE 
				primary_id = ".$article_create_data_array["draft_primary_id"]."")->execute();
//UPDATE `fuel_sharetube`.`draft` SET `sub_text` = 'hjkh' WHERE `draft`.`primary_id` =55;
	}
	//------------------
	//サムネイル原本保存
	//------------------
	static function thumbnail_original_create($random_key) {
		// サムネイル画像登録
		if($_FILES["file"]["error"] == 4) {

		}
			// ファイルがあれば
			else if($_FILES["file"]["error"] == 0) {
				// イメージ画像変数
				$icon_image = $_FILES["file"];
				// ファイル拡張子
				$type_str = str_replace("image/", "", $icon_image["type"], $count);
//				var_dump($type_str);
//				var_dump($count);
//				var_dump($icon_image["type"]);

				// 拡張子設定
				switch($type_str) {
					case 'jpeg':
						$extension = '.jpg';
					break;
					case 'gif':
						$extension = '.gif';
					break;
					case 'png':
						$extension = '.png';
					break;
					default:
						$extension = '.';
					break;
				}
				// パス設定
				$image_path    = $random_key.$extension;
				$image_2x_path = $random_key.'@2x'.$extension;
//				var_dump($image_path.$image_2x_path);
				$year = date("Y");
//				var_dump($year);
//				var_dump($icon_image);
				//-------------------------------------------
				// アップロード工程(イメージ画像であれば登録)
				//-------------------------------------------
				if (is_uploaded_file($icon_image["tmp_name"]) && $extension == ".jpg" or 
							$extension == ".gif" or $extension == ".png") {
					// 作成場所
					$create_dir = 'draft/article/';
					// ディレクトリ作成
					Model_Dir_Basis::thumbnail_dir_create($create_dir, $year);
					// 作成場所
					$create_dir = (PATH.'assets/img/draft/article/'.$year.'/');
				}
				// 原本ファイルUP
				if (move_uploaded_file($icon_image["tmp_name"], $create_dir.'/original/'.$image_path)) {
					// パーミッション変更
					chmod($create_dir.$image_path, 0755);
				}
			}
		return $image_path;
	}
	//------------------------
	//サムネイル原本db書き込み
	//------------------------
	static function thumbnail_data_save($random_key, $image_path) {
		DB::query("
			INSERT INTO draft_thumbnail (
				random_key,
				thumbnail_image
			)
			VALUES (
				'".$random_key."',
				'".$image_path."')")->execute();
	}
	//----------------------------
	//下書きのサムネイルネーム取得
	//----------------------------
	static function thumbnail_name_get($random_key) {
		$thumbnail_name_res = DB::query("
			SELECT *
			FROM draft_thumbnail
			WHERE random_key = '".$random_key."'
			LIMIT 0 , 1")->execute();
//			var_dump($thumbnail_name_res);
			foreach($thumbnail_name_res as $kry => $value) {
				$thumbnail_image = $value["thumbnail_image"];
			}
		return $thumbnail_image;
	}
	//--------------------
	//下書きを非表示にする
	//--------------------
	static function draft_hide($post) {
//		var_dump($post);
		DB::query("
			UPDATE draft SET
				draft = 0
			WHERE primary_id = ".$post["draft_primary_id"]."
		")->execute();
	}
}
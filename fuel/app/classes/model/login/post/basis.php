<?php 

/**
 * ポスト関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Post_Basis extends Model {
	//------------------
	//記事作成データ取得
	//------------------
	static function article_create_data_get($post) {
		$article_create_data_array = '';
//		var_dump($post);
		// 変数群
		$sharetube_id    = $_SESSION["sharetube_id"];
		$category        = $post["category"];
		$title           = $post["title"];
//		$sub_text        = htmlspecialchars_decode($post["sub_text"], ENT_COMPAT);
		$sub_text        = $post["sub_text"];
		$contents        = htmlspecialchars_decode($post["contents"], ENT_COMPAT);
		$text            = htmlspecialchars_decode($post["text"], ENT_COMPAT);
		$tag             = $post["tag"];
		$original        = $post["original"];
		$thumbnail_imege = $_FILES["file"];
		$sp_thumbnail    = (int)$post["sp_thumbnail"];
		$article_type    = $post["article_type"];

		// 削除array
		$del_r_array = array("'");
		// 不要文字置換
		$sub_text = str_replace($del_r_array, '"', $sub_text);
		$contents = str_replace($del_r_array, '"', $contents);
		$text     = str_replace($del_r_array, '"', $text);

		$now_time          = time();
		$now_date          = date('Y-m-d', $now_time);
		$create_date       = date('Y-m-d H:i:s', $now_time);
		$article_year_time = date('Y', $now_time);

		// path取得
		$res = DB::query("
			SELECT COUNT(primary_id)
			FROM ".$article_type."")->execute();
		foreach($res as $key => $value) {
			$path = (int)$value["COUNT(primary_id)"];
			$path++;
		}
		// 記事のパス
		$link = ($path);

		// 詰め込み
		$article_create_data_array = array(
			'sharetube_id'      => $sharetube_id,
			'category'          => $category,
			'title'             => $title,
			'sub_text'          => $sub_text,
			'contents'          => $contents,
			'text'              => $text,
			'tag'               => $tag,
			'original'          => $original,
			'thumbnail_image'   => $thumbnail_imege,
			'sp_thumbnail'      => $sp_thumbnail,
			'article_type'      => $article_type,
			'link'              => $link,
			'create_date'       => $create_date,
			'article_year_time' => $article_year_time,
			'draft_save'        => $post["draft_save"],
			'random_key'        => $post["random_key"],
			'draft_primary_id' => $post["draft_primary_id"],
		);
//var_dump($article_create_data_array);
		return $article_create_data_array;
	}
	
	//--------
	//記事作成
	//--------
	public static function article_create($post, $matome_frg = false) {
		// カテゴリー情報取得
		$category_info_array = Model_Info_Basis::category_info_get($post["category"]);
		if($matome_frg) {
			$post["matome_frg"] = 1;
		}
			else {
				$post["matome_frg"] = 0;
			}
		// 記事登録
		DB::query(
			"INSERT INTO ".$post["article_type"]." (
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
				matome_frg, 
				random_key, 
				update_time
			)
			VALUES (
				'".$post["sharetube_id"]."',
				'".$category_info_array["category_name"]."',
				'".$post["title"]."',
				'".$post["sub_text"]."',
				'".$post["contents"]."',
				'".$post["text"]."',
				'".$post["tag"]."',
				'".$post["original"]."',
				'".$post["thumbnail_image"]."',
				".(int)$post["sp_thumbnail"].", 
				'".$post["link"]."',
				".(int)$post["matome_frg"].",
				'".$post["random_key"]."',
				'".$post["create_date"]."')")->execute();
	}
	//--------------
	//サムネイル作成
	//--------------
	public static function thumbnail_create($create_dir, $image_path) {
		// コピー元画像の指定
//		$targetImage = ($create_dir.'original/'.$image_path);
		$targetImage = PATH.'assets/img/draft/article/'.date("Y").'/original/'.$image_path;

//		var_dump($targetImage);
		// 拡張子取得
		$type_str = substr($image_path, strrpos($image_path, '.') + 1);
		// 置換（jpg→jpeg）
		$type_str = str_replace("jpg","jpeg", $type_str);
//		var_dump($type_str);
		// ファイル名から、画像インスタンスを生成
		switch ($type_str) {
			case 'jpeg':
				$image = imagecreatefromjpeg($targetImage);
			break;
			case 'gif':
				$image = imagecreatefromgif($targetImage);
			break;
			case 'png':
				$image = imagecreatefrompng($targetImage);
			break;
			default:
				
			break;
		}
		// コピー元画像のファイルサイズを取得
		list($image_w, $image_h) = getimagesize($targetImage);
		// 比率取得
		// 横幅の方が大きい場合
		if($image_w > $image_h) {
			$i           = $image_h / $image_w;
			$ogp_1       = 1200 * $i;
			$ii_1        = 1280 * $i;
			$ii_2        = 640  * $i;
			$ll_1        = 520  * $i;
			$ll_2        = 260  * $i;
			$square_size = $image_h;
			$image_s_w   = ($image_w - $image_h) / 2;
			$image_s_h   = 0;
		}
			// 縦幅の方が大きい場合
			else if($image_w < $image_h) {
				$i           = $image_h / $image_w;
				$ogp_1       = 1200 * $i;
				$ii_1        = 1280 * $i;
				$ii_2        = 640  * $i;
				$ll_1        = 520  * $i;
				$ll_2        = 260  * $i;
				$square_size = $image_w;
				$image_s_w   = 0;
				$image_s_h   = ($image_h - $image_w) / 2;
			}
				// 同じ大きさの場合
				else {
					$i           = $image_h / $image_w;
					$ogp_1       = 1200 * $i;
					$ii_1        = 1280 * $i;
					$ii_2        = 640  * $i;
					$ll_1        = 520  * $i;
					$ll_2        = 260  * $i;
					$square_size = $image_w;
					$image_s_w = 0;
					$image_s_h = 0;
				}
			//-------------------
			//facebook_ogp_reseve
			//-------------------
			// サイズを指定して、背景用画像を生成
			$width  = 1200;
			$height = $ogp_1;
			$canvas = imagecreatetruecolor($width, $height);
		imagecopyresampled($canvas,  // 背景画像
		                   $image,   // コピー元画像
		                   0,        // 背景画像の x 座標
		                   0,        // 背景画像の y 座標
		                   0,        // コピー元の x 座標
		                   0,        // コピー元の y 座標
		                   $width,   // 背景画像の幅
		                   $height,  // 背景画像の高さ
		                   $image_w, // コピー元画像ファイルの幅
		                   $image_h  // コピー元画像ファイルの高さ
		                  );
				// 画像ファイル作成
				switch ($type_str) {
					case 'jpeg':
//					var_dump($create_dir.'facebook_ogp_reseve/'.$image_path);
						imagejpeg($canvas, $create_dir.'facebook_ogp_reseve/'.$image_path, 96);
					break;
					case 'gif':
						imagegif($canvas, $create_dir.'facebook_ogp_reseve/'.$image_path);
					break;
					case 'png':
						imagepng($canvas, $create_dir.'facebook_ogp_reseve/'.$image_path, 6);
					break;
					default:
					break;
				}
				// パーミッション変更
				chmod($create_dir.'facebook_ogp_reseve/'.$image_path, 0777);

			//------------
			//facebook_ogp
			//------------
			// コピー元画像の指定
			$target_ogp_Image = ($create_dir.'facebook_ogp_reseve/'.$image_path);
			// ファイル名から、画像インスタンスを生成
			switch ($type_str) {
				case 'jpeg':
					$ogp_image = imagecreatefromjpeg($target_ogp_Image);
				break;
				case 'gif':
					$ogp_image = imagecreatefromgif($target_ogp_Image);
				break;
				case 'png':
					$ogp_image = imagecreatefrompng($target_ogp_Image);
				break;
				default:
					
				break;
			}
			// コピー元画像のファイルサイズを取得
			list($image_ogp_w, $image_ogp_h) = getimagesize($target_ogp_Image);
			// 比率取得
			$image_ogp_c_w = 0;
			// 余りを求める
			$image_ogp_c_h = (($image_ogp_h - 630) / 2);
			// サイズを指定して、背景用画像を生成
			$ogp_width  = 1200;
			$ogp_height = 630;
//						var_dump('aaaaaaaaaaaaaaaaaa'.$image_ogp_c_h);
			// 比率がマイナスの場合
			if($image_ogp_c_h < 0) {
				// 比率を計算する
				$ogp_r_1 = $ogp_width / $ogp_height;
				// 比率の大きさに変える
				$image_ogp_w = $image_ogp_r_w = ($image_ogp_h * $ogp_r_1);
				// 余った分を切る
				$image_ogp_c_w = ($ogp_width - $image_ogp_w) / 2;
				// 0にしとく
				$image_ogp_c_h = 0;
/*
				var_dump('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'.$ogp_width);
				var_dump('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'.$ogp_height);
				var_dump('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'.$image_ogp_c_w);
				var_dump('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'.$image_ogp_c_h);
				var_dump('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'.$image_ogp_w);
				var_dump('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'.$image_ogp_h);
*/
				$canvas = imagecreatetruecolor($image_ogp_w, $image_ogp_h);
				imagecopy(
					$canvas,        // コピー先のリンクソース
					$ogp_image,     // コピー元の画像リンクソース
					0,              // コピー先のx座標
					0,              // コピー先のy座標
					$image_ogp_c_w, // コピー元のx座標 横
					$image_ogp_c_h, // コピー元のy座標 縦
					$image_ogp_w,   // コピー元の幅
					$image_ogp_h    // コピー元の高さ
				);
//					var_dump($create_dir.'facebook_ogp/'.$image_path);
				// 画像ファイル作成
				switch ($type_str) {
					case 'jpeg':
						imagejpeg($canvas, $create_dir.'facebook_ogp/'.$image_path, 96);
					break;
					case 'gif':
						imagegif($canvas, $create_dir.'facebook_ogp/'.$image_path);
					break;
					case 'png':
						imagepng($canvas, $create_dir.'facebook_ogp/'.$image_path, 6);
					break;
					default:
					break;
				}
				// コピー元画像の指定
				$target_ogp_Image = ($create_dir.'facebook_ogp/'.$image_path);
				// ファイル名から、画像インスタンスを生成
				switch ($type_str) {
					case 'jpeg':
						$ogp_image = imagecreatefromjpeg($target_ogp_Image);
					break;
					case 'gif':
						$ogp_image = imagecreatefromgif($target_ogp_Image);
					break;
					case 'png':
						$ogp_image = imagecreatefrompng($target_ogp_Image);
					break;
					default:
						
					break;
				}
				// コピー元画像のファイルサイズを取得
				list($image_ogp_w, $image_ogp_h) = getimagesize($target_ogp_Image);
				// サイズを指定して、背景用画像を生成
				$ogp_width  = 1200;
				$ogp_height = 630;
				$canvas = imagecreatetruecolor($ogp_width, $ogp_height);
				imagecopyresampled(
					$canvas,      // 背景画像
					$ogp_image,   // コピー元画像
					0,            // 背景画像の x 座標
					0,            // 背景画像の y 座標
					0,            // コピー元の x 座標
					0,            // コピー元の y 座標
					$ogp_width,   // 背景画像の幅
					$ogp_height,  // 背景画像の高さ
					$image_ogp_w, // コピー元画像ファイルの幅
					$image_ogp_h  // コピー元画像ファイルの高さ
         );
				// 画像ファイル作成
				switch ($type_str) {
					case 'jpeg':
						imagejpeg($canvas, $create_dir.'facebook_ogp/'.$image_path, 96);
					break;
					case 'gif':
						imagegif($canvas, $create_dir.'facebook_ogp/'.$image_path);
					break;
					case 'png':
						imagepng($canvas, $create_dir.'facebook_ogp/'.$image_path, 6);
					break;
					default:
					break;
				}
			} // if($image_ogp_c_h < 0) {
				// 比率がプラスの場合
				else if($image_ogp_c_h > 0) {
/*
					var_dump('aaaaaaaaaaaaaaaaaa'.$image_ogp_c_h);
					var_dump('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'.$image_ogp_c_w);
					var_dump('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'.$image_ogp_c_h);
					var_dump('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'.$image_ogp_w);
					var_dump('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'.$image_ogp_h);
*/
					$canvas = imagecreatetruecolor($ogp_width, $ogp_height);
					imagecopy(
						$canvas,        // コピー先のリンクソース
						$ogp_image,     // コピー元の画像リンクソース
						0,              // コピー先のx座標
						0,              // コピー先のy座標
						$image_ogp_c_w, // コピー元のx座標 横
						$image_ogp_c_h, // コピー元のy座標 縦
						$image_ogp_w,   // コピー元の幅
						$image_ogp_h    // コピー元の高さ
					);
					// 画像ファイル作成
					switch ($type_str) {
						case 'jpeg':
							imagejpeg($canvas, $create_dir.'facebook_ogp/'.$image_path, 96);
						break;
						case 'gif':
							imagegif($canvas, $create_dir.'facebook_ogp/'.$image_path);
						break;
						case 'png':
							imagepng($canvas, $create_dir.'facebook_ogp/'.$image_path, 6);
						break;
						default:
						break;
					}
				}
				else {
					// 画像ファイル作成
					switch ($type_str) {
						case 'jpeg':
							imagejpeg($canvas, $create_dir.'facebook_ogp/'.$image_path, 96);
						break;
						case 'gif':
							imagegif($canvas, $create_dir.'facebook_ogp/'.$image_path);
						break;
						case 'png':
							imagepng($canvas, $create_dir.'facebook_ogp/'.$image_path, 6);
						break;
						default:
						break;
					}
				}
				// パーミッション変更
				chmod($create_dir.'facebook_ogp/'.$image_path, 0777);

			//------------------
			//facebook_ogp縮小版
			//------------------
			// コピー元画像の指定
			$targetImage = ($create_dir.'facebook_ogp/'.$image_path);
			// ファイル名から、画像インスタンスを生成
			switch ($type_str) {
				case 'jpeg':
					$half_image = imagecreatefromjpeg($targetImage);
				break;
				case 'gif':
					$half_image = imagecreatefromgif($targetImage);
				break;
				case 'png':
					$half_image = imagecreatefrompng($targetImage);
				break;
				default:
					
				break;
			}
			// コピー元画像のファイルサイズを取得
			list($image_ogp_w, $image_ogp_h) = getimagesize($targetImage);
			$image_half_w = $image_ogp_w / 2;
			$image_half_h = $image_ogp_h / 2;
			$canvas = imagecreatetruecolor($image_half_w, $image_half_h);
				imagecopyresampled(
					$canvas,      // 背景画像
					$half_image,   // コピー元画像
					0,            // 背景画像の x 座標
					0,            // 背景画像の y 座標
					0,            // コピー元の x 座標
					0,            // コピー元の y 座標
					$image_half_w,   // 背景画像の幅
					$image_half_h,  // 背景画像の高さ
					$image_ogp_w, // コピー元画像ファイルの幅
					$image_ogp_h  // コピー元画像ファイルの高さ
         );
			// 画像ファイル作成
			switch ($type_str) {
				case 'jpeg':
					imagejpeg($canvas, $create_dir.'facebook_ogp_half/'.$image_path, 96);
				break;
				case 'gif':
					imagegif($canvas, $create_dir.'facebook_ogp_half/'.$image_path);
				break;
				case 'png':
					imagepng($canvas, $create_dir.'facebook_ogp_half/'.$image_path, 6);
				break;
				default:
				break;
			}
			// パーミッション変更
			chmod($create_dir.'facebook_ogp_half/'.$image_path, 0777);

			//--------------------------
			//facebook_ogp縮小版の縮小版
			//--------------------------
			// コピー元画像のファイルサイズを取得
			list($image_ogp_w, $image_ogp_h) = getimagesize($targetImage);
			$image_half_half_w = (int)($image_ogp_w / 4);
			$image_half_half_h = (int)($image_ogp_h / 4);
			$canvas = imagecreatetruecolor($image_half_half_w, $image_half_half_h);
				imagecopyresampled(
					$canvas,            // 背景画像
					$half_image,        // コピー元画像
					0,                  // 背景画像の x 座標
					0,                  // 背景画像の y 座標
					0,                  // コピー元の x 座標
					0,                  // コピー元の y 座標
					$image_half_half_w, // 背景画像の幅
					$image_half_half_h, // 背景画像の高さ
					$image_ogp_w,       // コピー元画像ファイルの幅
					$image_ogp_h        // コピー元画像ファイルの高さ
         );
			// 画像ファイル作成
			switch ($type_str) {
				case 'jpeg':
					imagejpeg($canvas, $create_dir.'facebook_ogp_half_half/'.$image_path, 96);
				break;
				case 'gif':
					imagegif($canvas, $create_dir.'facebook_ogp_half_half/'.$image_path);
				break;
				case 'png':
					imagepng($canvas, $create_dir.'facebook_ogp_half_half/'.$image_path, 6);
				break;
				default:
				break;
			}
			// パーミッション変更
			chmod($create_dir.'facebook_ogp_half_half/'.$image_path, 0777);
















			//------
			//1280px
			//------
			// サイズを指定して、背景用画像を生成
			$width  = 1280;
			$height = $ii_1;
			$canvas = imagecreatetruecolor($width, $height);
		imagecopyresampled($canvas,  // 背景画像
		                   $image,   // コピー元画像
		                   0,        // 背景画像の x 座標
		                   0,        // 背景画像の y 座標
		                   0,        // コピー元の x 座標
		                   0,        // コピー元の y 座標
		                   $width,   // 背景画像の幅
		                   $height,  // 背景画像の高さ
		                   $image_w, // コピー元画像ファイルの幅
		                   $image_h  // コピー元画像ファイルの高さ
		                  );
				// 画像ファイル作成
				switch ($type_str) {
					case 'jpeg':
						imagejpeg($canvas, $create_dir.'detail/'.$image_2x_path, 96);
					break;
					case 'gif':
						imagegif($canvas, $create_dir.'detail/'.$image_2x_path);
					break;
					case 'png':
						imagepng($canvas, $create_dir.'detail/'.$image_2x_path, 6);
					break;
					default:
					break;
				}

			//-----
			//640px
			//-----
			// サイズを指定して、背景用画像を生成
			$width  = 640;
			$height = $ii_2;
			$canvas = imagecreatetruecolor($width, $height);
		imagecopyresampled($canvas,  // 背景画像
		                   $image,   // コピー元画像
		                   0,        // 背景画像の x 座標
		                   0,        // 背景画像の y 座標
		                   0,        // コピー元の x 座標
		                   0,        // コピー元の y 座標
		                   $width,   // 背景画像の幅
		                   $height,  // 背景画像の高さ
		                   $image_w, // コピー元画像ファイルの幅
		                   $image_h  // コピー元画像ファイルの高さ
		                  );
				// 画像ファイル作成
				switch ($type_str) {
					case 'jpeg':
						imagejpeg($canvas, $create_dir.'detail/'.$image_path, 98);
					break;
					case 'gif':
						imagegif($canvas, $create_dir.'detail/'.$image_path);
					break;
					case 'png':
						imagepng($canvas, $create_dir.'detail/'.$image_path, 6);
					break;
					default:
					break;
				}
			// パーミッション変更
			chmod($create_dir.'detail/'.$image_path, 0777);

			//-----
			//520px
			//-----
			// サイズを指定して、背景用画像を生成
			$width  = 520;
			$height = $ll_1;
			$canvas = imagecreatetruecolor($width, $height);
		imagecopyresampled($canvas,  // 背景画像
		                   $image,   // コピー元画像
		                   0,        // 背景画像の x 座標
		                   0,        // 背景画像の y 座標
		                   0,        // コピー元の x 座標
		                   0,        // コピー元の y 座標
		                   $width,   // 背景画像の幅
		                   $height,  // 背景画像の高さ
		                   $image_w, // コピー元画像ファイルの幅
		                   $image_h  // コピー元画像ファイルの高さ
		                  );
				// 画像ファイル作成
				switch ($type_str) {
					case 'jpeg':
						imagejpeg($canvas, $create_dir.'thumbnail/'.$image_2x_path, 100);
					break;
					case 'gif':
						imagegif($canvas, $create_dir.'thumbnail/'.$image_2x_path);
					break;
					case 'png':
						imagepng($canvas, $create_dir.'thumbnail/'.$image_2x_path, 6);
					break;
					default:
					break;
				}

			//-----
			//260px
			//-----
			// サイズを指定して、背景用画像を生成
			$width  = 260;
			$height = $ll_2;
			$canvas = imagecreatetruecolor($width, $height);
		imagecopyresampled($canvas,  // 背景画像
		                   $image,   // コピー元画像
		                   0,        // 背景画像の x 座標
		                   0,        // 背景画像の y 座標
		                   0,        // コピー元の x 座標
		                   0,        // コピー元の y 座標
		                   $width,   // 背景画像の幅
		                   $height,  // 背景画像の高さ
		                   $image_w, // コピー元画像ファイルの幅
		                   $image_h  // コピー元画像ファイルの高さ
		                  );
				// 画像ファイル作成
				switch ($type_str) {
					case 'jpeg':
						imagejpeg($canvas, $create_dir.'thumbnail/'.$image_path, 100);
					break;
					case 'gif':
						imagegif($canvas, $create_dir.'thumbnail/'.$image_path);
					break;
					case 'png':
						imagepng($canvas, $create_dir.'thumbnail/'.$image_path, 6);
					break;
					default:
					break;
				}
			// パーミッション変更
			chmod($create_dir.'thumbnail/'.$image_path, 0777);

			//----------------
			//サムネイル正方形
			//----------------
			// サイズを指定して、背景用画像を生成
			$width  = $square_size;
			$height = $square_size;
			$canvas = imagecreatetruecolor($width, $height);
		imagecopy(
					$canvas,         // コピー先のリンクソース
					$image,          // コピー元の画像リンクソース
					0,               // コピー先のx座標
					0,               // コピー先のy座標
					$image_s_w,      // コピー元のx座標 横
					$image_s_h,      // コピー元のy座標 縦
					$image_w,        // コピー元の幅
					$image_h         // コピー元の高さ
									);
				// 画像ファイル作成
				switch ($type_str) {
					case 'jpeg':
						imagejpeg($canvas, $create_dir.'square/'.$image_path, 100);
					break;
					case 'gif':
						imagegif($canvas, $create_dir.'square/'.$image_path);
					break;
					case 'png':
						imagepng($canvas, $create_dir.'square/'.$image_path, 6);
					break;
					default:
					break;
				}
			// パーミッション変更
			chmod($create_dir.'square/'.$image_path, 0777);

				//------------------------------------------------
				//正方形の画像作成の為もう一度画像インスタンス生成
				//------------------------------------------------
				// コピー元画像の指定
				$targetImage = ($create_dir.'square/'.$image_path);
				// ファイル名から、画像インスタンスを生成
				switch ($type_str) {
					case 'jpeg':
						$image = imagecreatefromjpeg($targetImage);
					break;
					case 'gif':
						$image = imagecreatefromgif($targetImage);
					break;
					case 'png':
						$image = imagecreatefrompng($targetImage);
					break;
					default:
						
					break;
				}
				// コピー元画像のファイルサイズを取得
				list($image_w, $image_h) = getimagesize($targetImage);
				//-----------
				//200px正方形
				//-----------
				// サイズを指定して、背景用画像を生成
				$width  = 200;
				$height = 200;
				$canvas = imagecreatetruecolor($width, $height);
		imagecopyresampled($canvas,  // 背景画像
		                   $image,   // コピー元画像
		                   0,        // 背景画像の x 座標
		                   0,        // 背景画像の y 座標
		                   0,        // コピー元の x 座標
		                   0,        // コピー元の y 座標
		                   $width,   // 背景画像の幅
		                   $height,  // 背景画像の高さ
		                   $image_w, // コピー元画像ファイルの幅
		                   $image_h  // コピー元画像ファイルの高さ
		                  );
					// 画像ファイル作成
					switch ($type_str) {
						case 'jpeg':
							imagejpeg($canvas, $create_dir.'square_200px/'.$image_path, 100);
						break;
						case 'gif':
							imagegif($canvas, $create_dir.'square_200px/'.$image_path);
						break;
						case 'png':
							imagepng($canvas, $create_dir.'square_200px/'.$image_path, 6);
						break;
						default:
						break;
					}
			// パーミッション変更
			chmod($create_dir.'square_200px/'.$image_path, 0777);

				//-----------
				//120px正方形
				//-----------
				// サイズを指定して、背景用画像を生成
				$width  = 120;
				$height = 120;
				$canvas = imagecreatetruecolor($width, $height);
		imagecopyresampled($canvas,  // 背景画像
		                   $image,   // コピー元画像
		                   0,        // 背景画像の x 座標
		                   0,        // 背景画像の y 座標
		                   0,        // コピー元の x 座標
		                   0,        // コピー元の y 座標
		                   $width,   // 背景画像の幅
		                   $height,  // 背景画像の高さ
		                   $image_w, // コピー元画像ファイルの幅
		                   $image_h  // コピー元画像ファイルの高さ
		                  );
					// 画像ファイル作成
					switch ($type_str) {
						case 'jpeg':
							imagejpeg($canvas, $create_dir.'square_120px/'.$image_path, 100);
						break;
						case 'gif':
							imagegif($canvas, $create_dir.'square_120px/'.$image_path);
						break;
						case 'png':
							imagepng($canvas, $create_dir.'square_120px/'.$image_path, 6);
						break;
						default:
						break;
					}
			// パーミッション変更
			chmod($create_dir.'square_120px/'.$image_path, 0777);

				// メモリ開放
				imagedestroy($canvas);
		return $image_path;
	} // public static function thumbnail_create($thumbnail_imeg) {
	//------------------
	//サムネイルをコピー
	//------------------
	static function draft_thumbnail_copy($article_create_data_array) {
//		var_dump($article_create_data_array);
// 全ての PHP エラーを表示する
//error_reporting(-1);

		// コピー元（マスターパス）
		$draft_thumbnail_path = (PATH.'assets/img/draft/article/'.$article_create_data_array["article_year_time"]);
		// コピー先（マスターパス）
		$article_thumbnail_path = (PATH.'assets/img/article/'.$article_create_data_array["article_year_time"]);
		// ファイルが存在するかチェックし、あればサムネイルコピー
//		if(!file_exists($draft_thumbnail_file_path)) {
			// 
			$draft_thumbnail_detail_path                 = $draft_thumbnail_path.'/detail/'.$article_create_data_array["thumbnail_image"];
			$draft_thumbnail_facebook_ogp_path           = $draft_thumbnail_path.'/facebook_ogp/'.$article_create_data_array["thumbnail_image"];
			$draft_thumbnail_facebook_ogp_half_path      = $draft_thumbnail_path.'/facebook_ogp_half/'.$article_create_data_array["thumbnail_image"];
			$draft_thumbnail_facebook_ogp_half_half_path = $draft_thumbnail_path.'/facebook_ogp_half_half/'.$article_create_data_array["thumbnail_image"];
			$draft_thumbnail_facebook_ogp_reseve_path    = $draft_thumbnail_path.'/facebook_ogp_reseve/'.$article_create_data_array["thumbnail_image"];
			$draft_thumbnail_original_path               = $draft_thumbnail_path.'/original/'.$article_create_data_array["thumbnail_image"];
			$draft_thumbnail_square_path                 = $draft_thumbnail_path.'/square/'.$article_create_data_array["thumbnail_image"];
			$draft_thumbnail_square_200px_path           = $draft_thumbnail_path.'/square_200px/'.$article_create_data_array["thumbnail_image"];
			$draft_thumbnail_square_120px_path           = $draft_thumbnail_path.'/square_120px/'.$article_create_data_array["thumbnail_image"];
			$draft_thumbnail_thumbnail_path              = $draft_thumbnail_path.'/thumbnail/'.$article_create_data_array["thumbnail_image"];

			// 拡張子取得
			$extends = str_replace($article_create_data_array["random_key"], "", $article_create_data_array["thumbnail_image"]);
			// 記事ナンバーを付ける
			$thumbnail_name = $article_create_data_array["link"].$extends;
//			var_dump($thumbnail_name);
			// コピー先
			$article_thumbnail_detail_path                 = $article_thumbnail_path.'/detail/'.$thumbnail_name;
			$article_thumbnail_facebook_ogp_path           = $article_thumbnail_path.'/facebook_ogp/'.$thumbnail_name;
			$article_thumbnail_facebook_ogp_half_path      = $article_thumbnail_path.'/facebook_ogp_half/'.$thumbnail_name;
			$article_thumbnail_facebook_ogp_half_half_path = $article_thumbnail_path.'/facebook_ogp_half_half/'.$thumbnail_name;
			$article_thumbnail_facebook_ogp_reseve_path    = $article_thumbnail_path.'/facebook_ogp_reseve/'.$thumbnail_name;
			$article_thumbnail_original_path               = $article_thumbnail_path.'/original/'.$thumbnail_name;
			$article_thumbnail_square_path                 = $article_thumbnail_path.'/square/'.$thumbnail_name;
			$article_thumbnail_square_200px_path           = $article_thumbnail_path.'/square_200px/'.$thumbnail_name;
			$article_thumbnail_square_120px_path           = $article_thumbnail_path.'/square_120px/'.$thumbnail_name;
			$article_thumbnail_thumbnail_path              = $article_thumbnail_path.'/thumbnail/'.$thumbnail_name;

			// コピー
			copy($draft_thumbnail_detail_path, $article_thumbnail_detail_path);
			copy($draft_thumbnail_facebook_ogp_path, $article_thumbnail_facebook_ogp_path);
			copy($draft_thumbnail_facebook_ogp_half_path, $article_thumbnail_facebook_ogp_half_path);
			copy($draft_thumbnail_facebook_ogp_half_half_path, $article_thumbnail_facebook_ogp_half_half_path);
			copy($draft_thumbnail_facebook_ogp_reseve_path, $article_thumbnail_facebook_ogp_reseve_path);
			copy($draft_thumbnail_original_path, $article_thumbnail_original_path);
			copy($draft_thumbnail_square_path, $article_thumbnail_square_path);
			copy($draft_thumbnail_square_200px_path, $article_thumbnail_square_200px_path);
			copy($draft_thumbnail_square_120px_path, $article_thumbnail_square_120px_path);
			copy($draft_thumbnail_thumbnail_path, $article_thumbnail_thumbnail_path);
//		}
	}
	//-------
	//rss作成
	//-------
	public static function rss_create() {
		// RSS自動作成
		$res = DB::query("
			SELECT * 
			FROM article
			WHERE del = 0
			ORDER BY article.primary_id DESC
			LIMIT 0, 10")->execute();
		// rssヘッダーダグ
		$rss_start = ('<?xml version="1.0" encoding="UTF-8"?>
		<rss xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" version="2.0">
		<channel>
		<title>'.TITLE.'</title>
		<atom:link href="'.HTTP.'feed.xml" rel="self" type="application/rss+xml"/>
		<link>'.HTTP.'</link>
		<description>
		<![CDATA[
		'.META_DESCRIPTION.'
		]]>
		</description>
		<language>ja</language>
		<copyright>Copyright 2014</copyright>
		
		<generator uri="'.HTTP.'">'.TITLE.'</generator>
		
		<sy:updatePeriod>hourly</sy:updatePeriod>
		<sy:updateFrequency>1</sy:updateFrequency>
		<lastBuildDate>'.date(r).'</lastBuildDate>');
		foreach($res as $key => $value) {
			// 記事作成時間取得
			$creation_time        = $value["create_time"];
			$unix_time            = strtotime($value["create_time"]);
			$year_time            = date('Y', $unix_time);
			$local_time           = date('Y-m-d', $unix_time);
			$local_japanese_time  = date('Y年m月d日', $unix_time);
			$article_year_time    = date('Y', $unix_time);

			// コンテンツテキスト合体
			$contents_text = $value["sub_text"].$value["text"];
			// HTMLタグを取り除く
			$contents_text = preg_replace('/<("[^"]*"|\'[^\']*\'|[^\'">])*>/', '', $contents_text);
			// 本文を512文字に丸める
			$strimwidth_contents = mb_strimwidth($contents_text, 0, 512, "...", 'utf8');
			// rss用の概要を生成
			$rss_summary = (
				'<div class="article_thumbnail">
					<img class="great_image_100 m_b_15" width="640" height="400" title="'.$value["title"].'" alt="'.$value["title"].'" src="'.HTTP.'assets/img/article/'.$year_time.'/facebook_ogp/'.$value["thumbnail_image"].'">
				</div>
				'.$strimwidth_contents.'
				<a href="'.HTTP.'article/'.$value["link"].'/" target="_brank">続きを読む</a>');

			// item生成
			$item .= (
				'<item>
					<title>'.$value["title"].'</title>
					<link>
					'.HTTP.'article/'.$value["link"].'/
					</link>
					<description>
					<![CDATA[
						'.$rss_summary.'
					]]>
					</description>
					<dc:creator>'.$value["sharetube_id"].'</dc:creator>
					<content:encoded>
					<![CDATA[
					'.$rss_summary.'
					]]>
					</content:encoded>
					<guid>
					'.HTTP.'article/'.$value["link"].'/
					</guid>
					<pubDate>'.date('r', $unix_time).'</pubDate>
				</item>'
			);
		} // foreach($res as $key => $value) {
		// rss終了タグ
		$rss_end = ('</channel>
		</rss>');
		// rss結合
		$rss = $rss_start.$item.$rss_end;
		// 改行コードをLFに置換
		$rss = str_replace(array("\r\n","\r"), "\n", $rss);
		// 書き直すファイルパス
		$file = PATH.'feed.xml';
		// ファイルのデータ取得
		// $current = file_get_contents($file);
		// rssデータをファイルに書き出す
		file_put_contents($file, $rss);
	}
	//-----------
	//rss作成 v.2
	//-----------
	public static function rss_create_2() {
		// RSS自動作成
		$res = DB::query("
			SELECT * 
			FROM article
			WHERE del = 0
			ORDER BY article.primary_id DESC
			LIMIT 0, 10")->execute();
		// rssヘッダーダグ
		$rss_start = ('<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
	<channel>
		<title>'.TITLE.'</title>
		<link>'.HTTP.'</link>
		<description>'.META_DESCRIPTION.'</description>
		<language>ja</language>
		<copyright>Copyright '.date('Y',time()).'</copyright>		
		<generator uri="'.HTTP.'">'.TITLE.'</generator>
		<lastBuildDate>'.date(r).'</lastBuildDate>');

		foreach($res as $key => $value) {
			// 記事作成時間取得
			$creation_time        = $value["create_time"];
			$unix_time            = strtotime($value["create_time"]);
			$year_time            = date('Y', $unix_time);
			$local_time           = date('Y-m-d', $unix_time);
			$local_japanese_time  = date('Y年m月d日', $unix_time);
			$article_year_time    = date('Y', $unix_time);

			// コンテンツテキスト合体
			$contents_text = $value["sub_text"].$value["text"];
			// 改行&タブを消す
			$contents_text = str_replace(array("\r\n","\r","\n","\t"), '', $contents_text);
			// HTMLタグを取り除く
			$contents_text = preg_replace('/<("[^"]*"|\'[^\']*\'|[^\'">])*>/', '', $contents_text);
			// 本文を512文字に丸める
			$strimwidth_contents = mb_strimwidth($contents_text, 0, 512, "...", 'utf8');
			// エンティティ化する
			$value["title"]      = htmlspecialchars($value["title"], ENT_QUOTES, 'UTF-8');

			// rss用の概要を生成
			$rss_summary = (
				'<div class="article_thumbnail">
					<img class="great_image_100 m_b_15" width="640" height="400" title="'.$value["title"].'" alt="'.$value["title"].'" src="'.HTTP.'assets/img/article/'.$year_time.'/facebook_ogp_half/'.$value["thumbnail_image"].'">
				</div>
				'.$strimwidth_contents.'
				<a href="'.HTTP.'article/'.$value["link"].'/" target="_brank">続きを読む</a>');
			// エンティティ化する
			$rss_summary = htmlspecialchars($rss_summary, ENT_QUOTES, 'UTF-8');

			// item生成
			$item .= (
				'<item>
					<title>'.$value["title"].'</title>
					<link>'.HTTP.'article/'.$value["link"].'/</link>
					<description>
						'.$rss_summary.'
					</description>
					<guid>'.HTTP.'article/'.$value["link"].'/</guid>
					<pubDate>'.date('r', $unix_time).'</pubDate>
				</item>');
		} // foreach($res as $key => $value) {
		// rss終了タグ
		$rss_end = ('</channel>
		</rss>');
		// rss結合
		$rss = $rss_start.$item.$rss_end;
		// 改行コードをLFに置換
		$rss = str_replace(array("\r\n","\r"), "\n", $rss);

		// 書き直すファイルパス
		$file = PATH.'feed.xml';
		// ファイルのデータ取得
		// $current = file_get_contents($file);
		// rssデータをファイルに書き出す
		file_put_contents($file, $rss);
	}
} // class Model_Login_Post_Basis extends Model {
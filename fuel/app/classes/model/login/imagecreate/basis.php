<?php 
/**
 * 画像生成関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Imagecreate_Basis extends Model {
	//--------------------
	//画像の拡張子を調べる
	//--------------------
	public static function image_extension_check($file_type) {
		// ファイル拡張子
		$type_str = str_replace("image/", "", $file_type, $count);
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
		return $extension;
	}
	//----------------
	//サムネイル正方形
	//----------------
	public static function image_square_create($image_path, $create_path, $image_size = 168) {
/*
		var_dump($image_path);
		var_dump($create_path);
*/
		// コピー元画像の指定
		$targetImage = $image_path;
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
//		var_dump($image_w, $image_h);
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
			// サイズを指定して、背景用画像を生成
			$width  = $square_size;
			$height = $square_size;
/*
			var_dump($width);
			var_dump($height);
*/
			$canvas = imagecreatetruecolor($width, $height);
			imagealphablending($canvas,false);
			imagesavealpha($canvas,true);
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
						imagejpeg($canvas, $create_path, 100);
					break;
					case 'gif':
						imagegif($canvas, $create_path);
					break;
					case 'png':
						imagepng($canvas, $create_path, 6);
					break;
					default:
					break;
				}
			// パーミッション変更
			chmod($image_path, 0777);
				//------------------------------------------------
				//正方形の画像作成の為もう一度画像インスタンス生成
				//------------------------------------------------
				// コピー元画像の指定
				$targetImage = ($image_path);
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
				//----------------
				//指定サイズ正方形
				//----------------
				// サイズを指定して、背景用画像を生成
				$width  = $image_size;
				$height = $image_size;
				$canvas = imagecreatetruecolor($width, $height);
				imagealphablending($canvas,false);
				imagesavealpha($canvas,true);
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
							imagejpeg($canvas, $create_path, 100);
						break;
						case 'gif':
							imagegif($canvas, $create_path);
						break;
						case 'png':
							imagepng($canvas, $create_path, 6);
						break;
						default:
						break;
					}
			// パーミッション変更
			chmod($image_path, 0777);
	}
}
?>
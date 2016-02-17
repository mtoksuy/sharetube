<?php
/*
* Ajax ユーザーアイコン画像ファイルアップロードコントローラー
* 
* 
* 
*/
class Controller_Ajax_Userprofileedit_Userprofileicon extends Controller {
	// アクション
	public function action_index() {
		// セッションスタート
		session_start();
		// filesがあったら
		if ($_FILES) {
		//	var_dump($_SESSION);
			// ファイル名
			$file_name  = $_SESSION["sharetube_id"];
			$image_name = $file_name;
			// ファイルタイプ
			$file_type = $_FILES["file"]["type"];
			// 一時的に保存された場所へのパス
			$file_temp = $_FILES["file"]["tmp_name"];
			// ファイルサイズ
			$file_size = $_FILES["file"]["size"];
			// 画像アップロードする場所
			$create_dir = (PATH.'assets/img/creators/icon/');
			// 拡張子チェック
			$extension = Model_Login_Imagecreate_Basis::image_extension_check($file_type);
			// ランダムの数字取得
			$mt_rand = mt_rand();
			// 作成する場所
			$create_path = $create_dir.$image_name.'_'.$mt_rand.$extension;
			// アップロードする場所
			$upload_path = $create_dir.$image_name.'_'.$mt_rand.$extension;
			// アップロード
			if(move_uploaded_file($file_temp, $upload_path)) {
				$image_num++;
				// パーミッション変更
				chmod($upload_path, 0777);
				// 更新
				DB::query("
					UPDATE user
						SET 
							profile_icon = '".$image_name.'_'.$mt_rand.$extension."'
						WHERE
							primary_id = ".$_SESSION["primary_id"]."")->execute();
			}
			// 画像URL
			$image_url = HTTP.'assets/img/creators/icon/'.$image_name.'_'.$mt_rand.$extension;
			// 正方形のアイコン画像生成
			Model_Login_Imagecreate_Basis::image_square_create($upload_path, $create_path, 168);
			////////
			//32px用
			////////
			// 画像アップロードする場所
			$create_dir = (PATH.'assets/img/creators/icon_32px/');
			// 作成する場所
			$create_path = $create_dir.$image_name.'_'.$mt_rand.$extension;
			// 正方形のアイコン画像生成
			Model_Login_Imagecreate_Basis::image_square_create($upload_path, $create_path, 32);
		} // if ($_FILES) {
		header ("Content-Type: text/javascript; charset=utf-8");
		$json_data = array(
					'image_url'         => $image_url,
		);
		return json_encode($json_data);
	}
}
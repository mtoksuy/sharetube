<?php
/*
* Ajax まとめ 画像ファイルアップロードコントローラー
* 
* 
* 
*/
class Controller_Ajax_Matome_Imagefileupload extends Controller {
	// アクション
	public function action_index() {
// セッションスタート
session_start();

// filesがあったら
if ($_FILES) {
	// ファイル名
	$file_name = $_FILES["file"]["name"];
	// ファイルタイプ
	$file_type = $_FILES["file"]["type"];
	// 一時的に保存された場所へのパス
	$file_temp = $_FILES["file"]["tmp_name"];
	// ファイルサイズ
	$file_size = $_FILES["file"]["size"];
	// 画像アップロードする場所
	$create_dir = (PATH.'assets/img/article/image/');
	// 保存するファイル名をDBから取得
	$image_upload_res = DB::query("SELECT MAX(primary_id) FROM image_upload")->execute();
	// resから保存するファイル名取得
	foreach($image_upload_res as $key => $value) {
		$image_number = (int)$value["MAX(primary_id)"];
		$image_number++;
		$image_name = 'image_'.$image_number;
	}
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
	// アップロード
	if(move_uploaded_file($file_temp, $create_dir.$image_name.$extension)) {
		$image_num++;
		// パーミッション変更
		chmod($create_dir.$image_name.$extension, 0777);
		// image_upload追記
		DB::query("
			INSERT INTO image_upload (
				sharetube_id ,
				image_name
			)
			VALUES (
				'".$_SESSION["sharetube_id"]."',
				'".$image_name.$extension."')")->execute();
	}
	// 画像URL
	$image_url = HTTP.'assets/img/article/image/'.$image_name.$extension;
	// まとめ編集で表示用HTML
	$image_matome_html = HTTP.'assets/img/article/image/'.$image_name.$extension;


} // if ($_FILES) {
		header ("Content-Type: text/javascript; charset=utf-8");
		$json_data = array(
/*
					'file'      => $_FILES,
					'post'      => $_POST,
*/
					'image_url' => $image_url,
		);
		return json_encode($json_data);
	}
}
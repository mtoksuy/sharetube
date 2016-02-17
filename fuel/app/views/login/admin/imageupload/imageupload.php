<form id="image_upload"  action="" method="post" enctype="multipart/form-data">
	<input type="file" name="file[]" id="file" multiple="multiple">
	<input type="submit" name="submit" value="アップロード">
</form>

<?php 

/***************************************************************

ビューでプログラミングをやってしまっているが、例外で記述している

***************************************************************/
$control_num  = 0;
$image_num    = 0;
$image_number = '';

// submitがあったら
if ($_POST["submit"]) {

//var_dump($_FILES["file"]["error"]);

	// 複数ファイルのアップロード対応
	foreach ($_FILES["file"]["error"] as $key => $value) {
		// ファイル名
		$file_name = $_FILES["file"]["name"][$key];
		// ファイルタイプ
		$file_type = $_FILES["file"]["type"][$key];
		// 一時的に保存された場所へのパス
		$file_temp = $_FILES["file"]["tmp_name"][$key];
		// ファイルサイズ
		$file_size = $_FILES["file"]["size"][$key];
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
			echo "ファイルのアップロードに成功しました。<br />";
			// パーミッション変更
			chmod($create_dir.$image_name.$extension, 0644);
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
			else {
				echo "ファイルのアップロードに失敗しました。";
			}
		// 吐き出すHTML生成
		$image_html .= '
<div class="great_image_set_100">
	<p class="m_0">
		<a target="_blank" href="http://sharetube.jp/assets/img/article/image/'.$image_name.$extension.'">
			<img class="o_8" src="http://sharetube.jp/assets/img/article/image/'.$image_name.$extension.'" width="640" height="400" alt="" title="">
		</a>
	</p>
	<p class="click_zoom blockquote_font text_right">画像をクリックで拡大</p>
</div>';
	} // foreach ($_FILES["file"]["error"] as $key => $value) {
	// textareaに入れる
	$image_html_textarea_html = '<textarea style="width: 1000px; height: 520px;">'.$image_html.'</textarea>';
	echo $image_html_textarea_html;
} // if ($_POST["submit"]) {
?>

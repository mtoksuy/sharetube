
			<iframe name="shumbnail_iframe" id="" style="display: none;"></iframe>

				<div class="columns_2 clearfix">
					<!-- new_post -->
					<div class="new_post">
						<div class="new_post_contents">
							<h1>新規投稿を追加</h1>
							<form id="post_form" action="" method="post" enctype="multipart/form-data">
								<?php 
//									var_dump($post_data);
									if($post_data["draft"] || $post_data["preview"]) {
										echo '<input type="hidden" name="draft_save" value="true">';
									}
									if($post_data["random_key"]) {
										echo '<input id="post_form_random_key" type="hidden" name="random_key" value="'.$post_data["random_key"].'">';
									}
									if($post_data["thumbnail_create"]) {
										echo '<input id="post_form_thumbnail_create" type="hidden" name="thumbnail_create" value="'.$post_data["thumbnail_create"].'">';
									}
									if($post_data["draft_primary_id"]) {
										echo '<input type="hidden" name="draft_primary_id" value="'.$post_data["draft_primary_id"].'">';
									}

//					var_dump(preg_match('/12/', '13'));



								?>
								<p class="m_0">タイトル</p>
								<input id="title" type="text" name="title" value="<?php echo $post_data["title"]; ?>">
								<p class="m_0">本文1</p>
								<textarea id="sub_text" name="sub_text"><?php echo $post_data["sub_text"]; ?></textarea>
								<p class="m_0">動画埋め込み</p>
								<textarea id="contents" class="contents" name="contents"><?php echo $post_data["contents"]; ?></textarea>
								<p class="m_0">本文2</p>
								<textarea id="text" name="text"><?php echo $post_data["text"]; ?></textarea>
								<p class="m_0">タグ</p>
								<input id="tag" type="text" name="tag" value="<?php echo $post_data["tag"]; ?>">
								<p class="m_0">Original</p>
								<input id="original" type="text" name="original" value="<?php echo $post_data["original"]; ?>">
						</div>
					</div> <!-- new_post -->
					<!-- postboxs -->
					<div class="postboxs">
						<!-- postbox -->
						<div class="postbox">
							<h3>公開</h3>
							<div class="postbox_contents">
								<input type="submit" name="draft" value="下書きとして保存">
								<a id="post-preview" target="_blank" href="<?php echo HTTP; ?>login/admin/post/preview/?p=<?php echo $post_data["primary_id"]; ?>&amp;preview=true" class="preview button">プレビュー</a>
	<!--
									<input type="submit" name="preview" value="プレビュー">
	-->
									<input type="submit" name="submit" value="投稿する">
							</div>
						</div> <!-- postbox -->
						<!-- postbox -->
						<div class="postbox">
							<h3>カテゴリー</h3>
							<div class="postbox_contents">
								<select id="category" name="category">
									<option value="イノベーション・スタートアップ" <?php if($post_data["category"] == 'イノベーション・スタートアップ') {echo 'selected'; } ?>>イノベーション・スタートアップ</option>
									<option value="エンタメ・カルチャー" <?php if($post_data["category"] == 'エンタメ・カルチャー') {echo 'selected'; } ?>>エンタメ・カルチャー</option>
									<option value="アニマル・コメディー" <?php if($post_data["category"] == 'アニマル・コメディー') {echo 'selected'; } ?>>アニマル・コメディー</option>
									<option value="アプリ・ガジェット" <?php if($post_data["category"] == 'アプリ・ガジェット') {echo 'selected'; } ?>>アプリ・ガジェット</option>
									<option value="web・テクノロジー" <?php if($post_data["category"] == 'web・テクノロジー') {echo 'selected'; } ?>>web・テクノロジー</option>
									<option value="アニメ・ゲーム" <?php if($post_data["category"] == 'アニメ・ゲーム') {echo 'selected'; } ?>>アニメ・ゲーム</option>
									<option value="ライフ・社会" <?php if($post_data["category"] == 'ライフ・社会') {echo 'selected'; } ?>>ライフ・社会</option>
									<option value="コラム" <?php if($post_data["category"] == 'コラム') {echo 'selected'; } ?>>コラム</option>


								</select>
							</div>
						</div> <!-- postbox -->
						<!-- postbox -->
						<div class="postbox">
							<h3>動画タイプ</h3>
							<div class="postbox_contents">
								<select id="article_type" name="article_type">
									<option value="article" <?php if($post_data["article_type"] == 'article') {echo 'selected'; } ?>>YouTube・Video</option>
									<option value="vine" <?php if($post_data["article_type"] == 'vine') {echo 'selected'; } ?>>Vine</option>
								</select>
							</div>
						</div> <!-- postbox -->
						<!-- postbox -->
						<div class="postbox">
							<h3>SP(スマホ)・サムネ自動表示</h3>
							<div class="postbox_contents">
								<input type="radio" id="sp_thumbnail_1" name="sp_thumbnail" value="1" <?php if($post_data["sp_thumbnail"] == '1') {echo 'checked="checked"'; } else if($post_data["sp_thumbnail"] == '0') { } else {echo 'checked="checked"'; } ?>>
								<label for="sp_thumbnail_1">表示する<label>
								<input type="radio" id="sp_thumbnail_0" name="sp_thumbnail" value="0" <?php if($post_data["sp_thumbnail"] == '0') {echo 'checked="checked"'; } ?>>
								<label for="sp_thumbnail_0">表示しない<label>
							</div>
						</div> <!-- postbox -->
							</form>
						<!-- postbox -->
						<div class="postbox">
							<h3>サムネイル</h3>
							<div class="postbox_contents">
									<?php 
										$random_key_css = '';
										if($post_data["random_key"]) {
											$random_key_css = 'display: none';
											echo '<img id="reader_image" src="'.HTTP.'assets/img/draft/article/'.date("Y").'/original/'.$post_data["random_key"].'.jpg" style="width: 100%; height: auto;">';
										}
										echo '<form id="thumbnail_form" action="'.HTTP.'login/admin/post/thumbnail/" method="post" target="shumbnail_iframe" enctype="multipart/form-data" style="'.$random_key_css.'"><input id="file" type="file" name="file"></form>';
?>
<?php if($post_data["random_key"]) { echo '<span class="thumbnail_form_delete_button" title="削除ボタン">×</span>';
 }?>
							</div>
						</div> <!-- postbox -->
					</div> <!-- postboxs -->
				</div>
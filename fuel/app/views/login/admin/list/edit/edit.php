	<div class="columns_2 clearfix">
		<!-- new_post -->
		<div class="new_post">
			<div class="new_post_contents">
				<h1>記事を編集中</h1>
				<form action="" method="post" enctype="multipart/form-data">
					<p class="m_0">タイトル</p>
					<input type="text" name="title" value="<?php echo $edit_data["title"]; ?>">
					<p class="m_0">本文1</p>
					<textarea name="sub_text"><?php echo $edit_data["sub_text"]; ?></textarea>
					<p class="m_0">動画埋め込み</p>
					<textarea class="contents" name="contents"><?php echo $edit_data["contents"]; ?></textarea>
					<p class="m_0">本文2</p>
					<textarea name="text"><?php echo $edit_data["text"]; ?></textarea>
					<p class="m_0">タグ</p>
					<input type="text" name="tag" value="<?php echo $edit_data["tag"]; ?>">
					<p class="m_0">Original</p>
					<input type="text" name="original" value="<?php echo $edit_data["original"]; ?>">
			</div>
		</div> <!-- new_post -->
		<!-- postboxs -->
		<div class="postboxs">
			<!-- postbox -->
			<div class="postbox">
				<h3>編集</h3>
				<div class="postbox_contents">
					<input type="submit" name="submit" value="編集する">
				</div>
			</div> <!-- postbox -->
			<!-- postbox -->
			<div class="postbox">
				<h3>カテゴリー</h3>
				<div class="postbox_contents">
					<select name="category">
						<option value="イノベーション・スタートアップ" <?php if($edit_data["category"] == 'イノベーション・スタートアップ') {echo 'selected'; } ?>>イノベーション・スタートアップ</option>
						<option value="エンタメ・カルチャー" <?php if($edit_data["category"] == 'エンタメ・カルチャー') {echo 'selected'; } ?>>エンタメ・カルチャー</option>
						<option value="アニマル・コメディー" <?php if($edit_data["category"] == 'アニマル・コメディー') {echo 'selected'; } ?>>アニマル・コメディー</option>
						<option value="アプリ・ガジェット" <?php if($edit_data["category"] == 'アプリ・ガジェット') {echo 'selected'; } ?>>アプリ・ガジェット</option>
						<option value="web・テクノロジー" <?php if($edit_data["category"] == 'web・テクノロジー') {echo 'selected'; } ?>>web・テクノロジー</option>
						<option value="アニメ・ゲーム" <?php if($edit_data["category"] == 'アニメ・ゲーム') {echo 'selected'; } ?>>アニメ・ゲーム</option>
						<option value="ライフ・社会" <?php if($edit_data["category"] == 'ライフ・社会') {echo 'selected'; } ?>>ライフ・社会</option>
						<option value="コラム" <?php if($edit_data["category"] == 'コラム') {echo 'selected'; } ?>>コラム</option>
					</select>
				</div>
			</div> <!-- postbox -->
						<!-- postbox -->
						<div class="postbox">
							<h3>SP(スマホ)・サムネ自動表示</h3>
							<div class="postbox_contents">
								<input type="radio" id="sp_thumbnail_1" name="sp_thumbnail" value="1" <?php if($edit_data["sp_thumbnail"] ===  1) { echo 'checked="checked"'; } ?>>
								<label for="sp_thumbnail_1">表示する<label>
								<input type="radio" id="sp_thumbnail_0" name="sp_thumbnail" value="0" <?php if($edit_data["sp_thumbnail"] ===  0) { echo 'checked="checked"'; } ?>>
								<label for="sp_thumbnail_0">表示しない<label>
							</div>
						</div> <!-- postbox -->
			<input type="hidden" name="article_id" value="<?php echo $edit_data["primary_id"]; ?>">
			<input type="hidden" name="article_type" value="article">
		</form>
	</div> <!-- postboxs -->
</div> <!-- columns_2 -->

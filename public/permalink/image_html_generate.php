<?php
$repeat_number = 8;
$start_number = 2916;
$image_number = '';


for($i = 0; $i < $repeat_number; $i++) {
	echo $start_number;
$image_html .= '<p class="m_0">
	<a target="_blank" href="http://sharetube.jp/assets/img/article/image/image_'.$start_number.'.jpg">
		<img class="great_image_100 o_8" src="http://sharetube.jp/assets/img/article/image/image_'.$start_number.'.jpg" width="640" height="400" alt="" title="">
	</a>
</p>
<p class="blockquote_font text_right">画像をクリックで拡大</p>
';
	$start_number++;
}
//echo $image_html;


$image_html_textarea_html = '<textarea style="width: 1000px; height: 720px;">'.$image_html.'</textarea>';


echo $image_html_textarea_html;

?>
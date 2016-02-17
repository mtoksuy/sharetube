<!--
.great_image_set_100 {

}
.great_image_set_100 img,.great_image_set_50 img {
  background-color: #F9F9F9;
  border: 1px solid #E7E7E7;
  border-radius: 2px;
  box-sizing: border-box;
  height: auto;
  margin: 0;
  padding: 5px;
}
.great_image_set_100 img {
  width: 100%;
}
.great_image_set_50 img {
  width: 50%;
}
.great_image_set_100 .click_zoom {
  width: 100%;
}
.great_image_set_50 .click_zoom {
  width: 50%;
}

-->

<?php
$number = 100;
$text = '';
while ($number > 0) {
	echo $number;
	echo '<br>';
$text  .= '.great_image_set_'.$number.' img, .great_image_set_'.$number.' .click_zoom { width: '.$number.'%; } ';
$number--;
}
echo $text;


// '.great_image_set_'.$number.' img';










?>
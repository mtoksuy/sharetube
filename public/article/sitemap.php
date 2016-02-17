<?php 
$start_number = 888;
$last_number  = 984;
$delta_number = $last_number - $start_number;
$original_html = '<url>
  <loc>http://sharetube.jp/article//</loc>
  <priority>0.9</priority>
</url>';
for($i = 1; $i <= $delta_number; $i++) {
    echo $i;
    echo '<br>';
$start_number++;
$feed_xml .= '<url>
  <loc>http://sharetube.jp/article/'.$start_number.'/</loc>
  <priority>0.9</priority>
</url>
';
}

echo $feed_xml;



for ($i = 1; $i <= 10; $i++) {
//    echo $i;
}




?>
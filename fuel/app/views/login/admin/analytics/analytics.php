<div class="article_list">
 <?php echo $content_data["content_html"]; ?>
 <?php 
/*
echo '<pre>';
var_dump($content_data["analytics_data"]);
echo '</pre>';
*/
?>

<?php
	$count     = 0;
	$day_count = 0;
	foreach($content_data["analytics_data"]["day"] as $key => $value) {
		$day_count++;
		$count = $count+$value["count"];
	}
	// PVアベレージ
	$average_pv = (int)($count/$day_count);

	// チャートデータ生成
	foreach($content_data["analytics_data"]["day"] as $key => $value) {
		$cahrt_data .= "['".$key."日', ".$value["count"]."], ";
	}
	$i =0;
	// analytics_page_list_content_link生成
	foreach($content_data["analytics_data"]["article_id"] as $key => $value) {
		$i++;
		if(($i % 2) == 0) {
			$even_class="";
		}
			else {
				$even_class="even";
			}
		$analytics_page_list_content_link_html .= '<li class="analytics_page_list_content_link '.$even_class.' clearfix">
		 		<a href="'.HTTP.'login/admin/analytics/article/'.$key.'/">
				 	<span class="analytics_page_list_content_link_title">'.$value["title"].'</span>
		 		</a>
				 	<span class="analytics_page_list_content_link_view">'.$value["count"].' view</span>
		 	</li>';
	}
?>

	<h1>Sharetube Analytics</h1>
	<!-- analytics_div -->
 	<div id="analytics_div" class="clearfix"></div>
 	<div class="analytics_data">
	 	<div class="analytics_data_content clearfix">
		 	<ul class="analytics_data_content_ul">
			 	<li class="analytics_data_content_ul_title">ページビュー数</li>
			 	<li class="analytics_data_content_ul_number"><?php echo $content_data["analytics_data"]["all_pv"]; ?></li>
			</ul>
		 	<ul class="analytics_data_content_ul">
			 	<li class="analytics_data_content_ul_title">平均PV数</li>
			 	<li class="analytics_data_content_ul_number"><?php echo $average_pv; ?></li>
			</ul>
		</div>
	</div> <!-- <div class="analytics_data"> -->
	<!-- analytics_page_list -->	
 	<div class="analytics_page_list">
	 	<div class="analytics_page_list_title">ページタイトル</div>
	 	<div class="analytics_page_list_view">ビュー数</div>
	 	<ul class="analytics_page_list_content">
	 		<?php echo $analytics_page_list_content_link_html; ?>
		</ul>
	</div>
	






		<!-- analyticsプラグイン -->
		<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart']}]}"></script>

<script>

      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['day', 'PV'],
				<?php echo $cahrt_data; ?>
/*
['1日', 1892], 
['2日', 9481], 
['3日', 8819],
['4日', 1892], 
['5日', 9481], 
['6日', 8819],
['7日', 1892], 
['8日', 9481], 
['9日', 8819],
['10日', 1892], 
['11日', 9481], 
['12日', 8819],
['13日', 1892], 
['14日', 9481], 
['15日', 8819],
['16日', 1892], 
['17日', 9481], 
['18日', 8819],
['19日', 1892], 
['20日', 9481], 
['21日', 8819],
['22日', 1892], 
['23日', 9481], 
['24日', 8819],
['25日', 1892], 
['26日', 9481], 
['27日', 8819],
['28日', 1892], 
['29日', 9481], 
['30日', 8819],
*/
        ]);
        var options = {
          title: '<?php echo $content_data["analytics_data"]["analytics_title"]; ?>',
          hAxis: {title: '',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
	         width:1000,
	         height:400,
	         backgroundColor: {'stroke':'#FCFCFC','strokeWidth':10,'fill':'#FCFCFC'},
					 colors: ['#21a9e3'],
					 curveType: 'function',
					 pointSize: 8,
        };
        var chart = new google.visualization.AreaChart(document.getElementById('analytics_div'));
        chart.draw(data, options);
      }
</script>



</div>

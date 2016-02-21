<div class="article_list">
 <?php echo $content_data["content_html"]; ?>
 <?php 

/*
echo '<pre>';
var_dump($content_data);
echo '</pre>';
var_dump((int)($content_data["incentive_data_array"]["rate"]*$content_data["sharetube_user_data_array"]["pay_pv"]));
*/

// コンプリート
if($content_data["complete"] == true) {
	// 
	if($content_data["error_check"] == true) {
		echo '
	<p style="margin-top: 0px; color: green; font-size: 125%; font-weight: bold;">インセンティブお支払い受け付けました</p>
	<p>お支払いは2営業日以内に致します。</p>';
	}
		// エラー
		else {
			echo '予期せぬ画面遷移が行われました。ダッシュボードに戻ってください';
		}
}
	// payrequest
	else if($content_data["payrequest"] == true) {
			echo $content_data["incentive_payrequest_html"];
	}
		// index
		else {
			echo $content_data["incentive_html"];
			echo $content_data["incentive_paid_html"];
			echo '</div><!-- incentive_data_report_content -->
		</div> <!-- incentive_data_report -->';
		}
?>
</div>

<?php 
/**
 * testコントローラー
 * 
 * 様々なテストをする場所
 * 
 * 
 */

class Controller_Login_Admin_Test extends Controller_Login_Template {
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			$url = 'https://www.similarweb.com/website/qiita.com';
			$url = 'https://www.similarweb.com/website/sharetube.jp/';
//			$url = 'https://www.similarweb.com/website/sharetube.jp';




		// simple_html_domライブラリ読み込み
		require_once INTERNAL_PATH.'fuel/app/classes/library/simplehtmldom_1_5/simple_html_dom.php';
		// URLから
		$simple_html_dom_object = file_get_html($url);
		//////////
		//評価抽出
		//////////
		// コンテンツ取得
/*
		foreach($simple_html_dom_object->find('.stickyHeader-nameText') as $list) {
			 $noUnderline_html .= $list->outertext;
		}
*/





/*
pdf-pageBreakAfter
	websitePage-engagementInfo
		engagementInfo-line
			engagementInfo-valueNumber
*/

$i = 0;

			foreach($simple_html_dom_object->find('.websitePage-engagementInfo .engagementInfo-line .engagementInfo-valueNumber') as $list) {
			 	switch($i) {
			 		case 0:
			 			$json_html .= $list->outertext;
			 		break;
				}
			$i++;
		}
var_dump($json_html);


/*
 <span class="engagementInfo-valueNumber js-countValue">196</span>

*/



			return $this->login_admin_template;
		}
			// ログインしていない場合
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	}
}
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

		$url = 'http://potato.2ch.net/test/read.cgi/applism/1451606389';
		$subject = file_get_contents($url);
		echo $subject;

		// UTF-8にエンコード
		$subject = mb_convert_encoding($subject, 'UTF-8', 'auto');



		$url = 'http://potato.2ch.net/test/read.cgi/applism/1451606389';
$raw_contents = file_get_contents($url);
echo $raw_contents;

$raw_contents = mb_convert_encoding($raw_contents, "UTF-8", "SJIS");















		// simple_html_domライブラリ読み込み
		require_once INTERNAL_PATH.'fuel/app/classes/library/simplehtmldom_1_5/simple_html_dom.php';
		// URLから
		$simple_html_dom_object = file_get_html('http://potato.2ch.net/test/read.cgi/applism/1451606389');
var_dump($simple_html_dom_object);
/*
		// コンテンツ取得
		foreach($simple_html_dom_object->find('title') as $list) {
			 $permalink_tweet_container_html .= $list->outertext;
		}
*/
/*
		//開放
		$simple_html_dom_object->clear();
		// 変数破棄
		unset($simple_html_dom_object);

*/





















echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';


echo '■5個一気に合成した時の確率表';
echo '<br>';
echo  'スキルレベル6だった場合の成功確率'.round( 1-pow((0.6),5),2)*(100).'%';
echo '<br>';
echo  'スキルレベル7だった場合の成功確率'.round( 1-pow((0.7),5),2)*(100).'%';
echo '<br>';
echo  'スキルレベル8だった場合の成功確率'.round( 1-pow((0.8),5),2)*(100).'%';
echo '<br>';
echo  'スキルレベル9だった場合の成功確率'.round( 1-pow((0.9),5),2)*(100).'%';





//echo pow(2,40);
/*
一回外れる確率は 9/10(=1-(1/10)). これを 10 回行うので, すべて外れる確率は (9/10)10となる. あとは１からこれを引いて, 
1-(9/10)10=0.651322…≒65.13%
となり, 確率は半分強となる. 意外と少ない？多い？ 参考までに, 1/20 を 20 回などの確率を書いておく.

80%×80%×80%×80%×80%＝（0.8）^5＝32.768%が白い玉を引き続ける確率です。
従って、１回でも赤い玉を引く確率は100%－32.768%＝６７．２３２％になります。
*/

echo '<br>';


echo '月パス '.round (480 / ((60*30)+280),2).'円';
echo '<br>';
echo '70水晶 '.round (120 / 70,2).'円';
echo '<br>';
echo '350水晶+おまけ70水晶 '.round (600 / (350+70),2).'円';
echo '<br>';
echo '720水晶+おまけ160水晶 '.round (1200 / (720+160),2).'円';
echo '<br>';
echo '1200水晶+おまけ320水晶 '.round (2000 / (1200+320),2).'円';
echo '<br>';
echo '1800水晶+おまけ600水晶 '.round (3000 / (1800+600),2).'円';
echo '<br>';
echo '3000水晶+おまけ1200水晶 '.round (5000 / (3000+1200),2).'円';
echo '<br>';
echo '6000水晶+おまけ2800水晶 '.round (9800 / (6000+2800),2).'円';
echo '<br>';
echo '［初回お得パック］';
echo '<br>';
echo '1200水晶+おまけ1200水晶 '.round (2000 / (1200+1200),2).'円';
echo '<br>';
echo '1800水晶+おまけ1800水晶 '.round (3000 / (1800+1800),2).'円';
echo '<br>';
echo '3000水晶+おまけ3000水晶 '.round (5000 / (3000+3000),2).'円';
echo '<br>';
echo '6000水晶+おまけ6000水晶 '.round (9800 / (6000+6000),2).'円';
echo '<br>';
echo '［初売りパック］(ゴミパック)';
echo '<br>';
echo '100水晶 or 120水晶 '.round (120 / (100),2).'円'.' or '.round (120 / (120),2).'円';







echo '<br>';
//= 7107.2

$attack        = 327;
$bullet        = 179;
$speed         = 8.5;

$number              = 0;
$kronos_damage       = 0;
$kronos_total_damage = 0;
$attack_damage       = 0;
$attack_total_damage = 0;
$total_damage        = 0;

function shadow_of_kronos($kronos_damage) {
	if($kronos_damage < 3760) {
		$kronos_damage = $kronos_damage+100;
			if($kronos_damage > 3760) {
				$kronos_damage = 3760;
			}
	}
		else {
			$kronos_damage = 3760;
		}
	return $kronos_damage;
}

while($bullet > 0) {
	$bullet--;
	$number++;
	$attack_total_damage = $attack+$attack_total_damage;
	$kronos_damage       = shadow_of_kronos($kronos_damage);
	$kronos_total_damage = $kronos_damage+$kronos_total_damage;
	$total_damage        = $attack_total_damage+$kronos_total_damage;
	echo $total_damage.' = '.$attack_total_damage.'(武器だけの攻撃合計値)+'.$kronos_total_damage.'(クロノスの合計値) '.$number.'発目'.'<br>';
}

/*
エラってるけど・・・
			// iTunes_app_スクレイピング
			$itunes_app_data_array = Model_Login_Itunesappscraping_Basis::itunes_app_scraping();
			// iTunes_app_html生成
			$itunes_app_html       = Model_Login_Itunesappscraping_Html::itunes_app_html_create($itunes_app_data_array);
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
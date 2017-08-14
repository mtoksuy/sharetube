<?php 
// レア変数
$rare_5 = 0;
$rare_4 = 0;
$rare_3 = 0;
$rare_2 = 0;

// レア毎の確率
$rare_5_probability = 125;
$rare_4_probability = 558;
$rare_3_probability = 2389;
$rare_2_probability = 6928;

// 回す回数
$run_number = 33;

// 1回回す為の金額
$run_money = 500;

// ランダムの確率
$random_probability = 10000;

// ガチャ回す
for($i = 0; $i < $run_number; $i++) {
// ランダム乱数取得
$probability = rand(1, $random_probability);

	if($probability <= $rare_5_probability) {
		$rare_5++;
	}
		else if($probability <= ($rare_4_probability + $rare_5_probability)) {
			$rare_4++;
		}
			else if($probability <=  ($rare_3_probability + $rare_4_probability + $rare_5_probability)) {
				$rare_3++;
			}
				else if($probability <= $rare_2_probability) {
					$rare_2++;
				}
					else {
						$rare_2++;
					}
} // for($i = 0; $i < $run_number; $i++) {

// 引けた確率
$pull_probability_5 =  ($rare_5 / $run_number) * 100;
$pull_probability_4 =  ($rare_4 / $run_number) * 100;
$pull_probability_3 =  ($rare_3 / $run_number) * 100;
$pull_probability_2 =  ($rare_2 / $run_number) * 100;

/*
echo 'レア度:★★★★★<br>';
echo $rare_5.'回引きました。';
echo '<br>';
echo $pull_probability_5.'%';


echo '<br><br>';


echo 'レア度:★★★★☆<br>';
echo $rare_4.'回引きました。';
echo '<br>';
echo $pull_probability_4.'%';


echo '<br><br>';


echo 'レア度:★★★☆☆<br>';
echo $rare_3.'回引きました。';
echo '<br>';
echo $pull_probability_3.'%';


echo '<br><br>';


echo 'レア度:★★☆☆☆<br>';
echo $rare_2.'回引きました。';
echo '<br>';
echo $pull_probability_2.'%';

echo '<br>';
echo '<br>';

// 回した合計金額
$total_run_money = $run_number * $run_money;
// カンマ挿入
$total_run_money = number_format($total_run_money);

echo '使ったお金は'.$total_run_money.'円です。';
*/
?>




































		<link rel="stylesheet" href="http://sharetube.jp/assets/css/common/common.css" type="text/css">
			<!-- jQueryプラグイン -->
			<script type="text/javascript" src="http://sharetube.jp/assets/js/common/jquery-1.9.1-min.js"></script>
<script>
/*************************
デバッグ変数コンストラクタ
*************************/
var p        = console.log;
var print    = console.log;
var var_dump = console.dir;
var trace    = console.trace;
var time     = console.time;
var count    = console.count;


// レア変数
var rare_5 = 0;
var rare_4 = 0;
var rare_3 = 0;
var rare_2 = 0;

// レア毎の確率
var rare_5_probability = 125;  // 1.25%
var rare_4_probability = 558;  // 5.58%
var rare_3_probability = 2389; // 23.89%
var rare_2_probability = 6928; // 69.28%

// 回す回数(デフォルト値)
var run_number = 100;

// 回す合計値
var total_run_number = 0;

// 1回回す為の金額
var run_money = 500;

//11連をした回数
var scout_11_count = 0;

// ランダムの確率
var random_probability = 10000;

// レア5選択
var rare_5_selecte = '';

// レア5選択array
var rare_5_selecte_array =  [];

// 引いたレア5を連結する変数
var hit_rare_5 = '';

// 特定のレアキャラカウント（ハルシュト）
var harushuto_count = 0;

// レア5の中身
var rare_5_array = ["モルーシャ", "レイ", "アウラ", "コーネリア", "ヴィルエル", "アルシオン", "ファーラ", "カイザー", "ミスティカ", "モクレン", "ロシャナク", "ジェラルド", "シエラ", "キャロル", "ユーヴェンス", "アナーヒト", "ハルシュト", "プロメテンド", "リベルディ", "まつかぜ", "トレノセリカ", "イヴ", "みおぎ", "ブラッド", "シトルイユ", "バルトロメイ", "ローザ", "シルフィカ", "グレゴトール"];

//----------------------------------
// min から max までの乱数を返す関数
//----------------------------------
function getRandomArbitary(min, max) {
  return Math.random() * (max - min) + min;
}

//------------------------------------
// min から max までの乱整数を返す関数
//------------------------------------
// Math.round() を用いると、非一様分布になります!
function getRandomInt(min, max) {
  return Math.floor( Math.random() * (max - min + 1) ) + min;
}

//---------------
// ガチャ回す関数
//---------------
function scout_gacha(run_number) {
	for(i = 0; i < run_number; i++) {
		total_run_number++;
		// ランダム乱数取得
		var probability = getRandomArbitary(1, random_probability);

		if(probability <= rare_5_probability) {
			rare_5++;
			// レア選択
			rare_5_selecte_array = rare_5_selecte_array.concat(Math.floor( Math.random() * rare_5_array.length));
		}
			else if(probability <= (rare_4_probability + rare_5_probability)) {
				rare_4++;
			}
				else if(probability <=  (rare_3_probability + rare_4_probability + rare_5_probability)) {
					rare_3++;
				}
					else if(probability <= rare_2_probability) {
						rare_2++;
					}
						else {
							rare_2++;
						}
	} // for(i = 0; i < run_number; i++) {
	// 回した合計金額
	var total_run_money = total_run_number * run_money;
	return total_run_money;
}
//------------------
//小数点切り捨て関数
//------------------
function number_point_truncate(truncate_number, truncate) {
	truncate_number = truncate_number * truncate;
	truncate_number = Math.round(truncate_number);
	truncate_number = truncate_number / truncate;
	return truncate_number;
}
//----------------
//スカウトする関数
//----------------
function scout_click(scout_number = 1) {
		// トータル金額
		var last_total_run_money = scout_gacha(scout_number);
		// 11連ボーナス
		last_total_run_money = parseInt(last_total_run_money) - (scout_11_count * 500);
		// カンマ挿入
		last_total_run_money = last_total_run_money.toLocaleString();
		// レア5が当たったかどうかの判定
		if (rare_5_selecte_array.length > 0) {
			// 引いたレア5を連結する変数 & 初期化
			hit_rare_5      = '';
			harushuto_count = 0;
			// ゲットできたレア5を連結する
			for(ii = 0; ii < rare_5_selecte_array.length; ii++) {
				hit_rare_5 += rare_5_array[rare_5_selecte_array[ii]] + '、 ';
				// ハルシュトをゲットしたら
				if(rare_5_selecte_array[ii] == 16) {
					harushuto_count++;
				}
			}
			// 末端のカンマ削除
			hit_rare_5 = hit_rare_5.slice(0, -2);
		}

		// 確率
		var pull_probability_5 = (rare_5 / total_run_number) * 100;
		var pull_probability_4 = (rare_4 / total_run_number) * 100;
		var pull_probability_3 = (rare_3 / total_run_number) * 100;
		var pull_probability_2 = (rare_2 / total_run_number) * 100;
		pull_probability_5     = number_point_truncate(pull_probability_5, 100);
		pull_probability_4     = number_point_truncate(pull_probability_4, 100);
		pull_probability_3     = number_point_truncate(pull_probability_3, 100);
		pull_probability_2     = number_point_truncate(pull_probability_2, 100);
		var text = '合計' + total_run_number + '回スカウトして・・・<br>使ったお金は<b style="font-size: 150%;">' + last_total_run_money + '</b>円です。' + '<br>また、特定のレア5キャラ（ハルシュト）を<b>' + harushuto_count + '</b>ゲット!!しまして、確率は<b>' + ((harushuto_count / total_run_number) * 100) + '</b>%と、なりました。<br>〜詳細結果〜<br>レア度：★★★★★<br>' + rare_5 + '回引きました。<br>確率：' + pull_probability_5 + '%<br><br>レア度：★★★★☆<br>' +rare_4 + '回引きました。<br>確率：' +pull_probability_4 + '%<br><br>レア度：★★★☆☆<br>' +rare_3 + '回引きました。<br>確率：' + pull_probability_3 + '%<br><br>レア度：★★☆☆☆<br>' +rare_2 + '回引きました。<br>確率：' + pull_probability_2 + '%<br><br>GETしたレア5キャラクター：' + hit_rare_5 + '';
		$('.scout_view').html(text);
}
//------
//初期化
//------
function initialization() {
		$('.scout_view').html('ここに結果が表示されます');
// レア変数
rare_5 = 0;
rare_4 = 0;
rare_3 = 0;
rare_2 = 0;

// レア毎の確率
rare_5_probability = 125;  // 1.25%
rare_4_probability = 558;  // 5.58%
rare_3_probability = 2389; // 23.89%
rare_2_probability = 6928; // 69.28%

// 回す回数(デフォルト値)
run_number = 100;

// 回す合計値
total_run_number = 0;

// 1回回す為の金額
run_money = 500;

//11連をした回数
scout_11_count = 0;

// ランダムの確率
random_probability = 10000;

// レア5選択
rare_5_selecte = '';

// レア5選択array
rare_5_selecte_array =  [];

// 引いたレア5を連結する変数
hit_rare_5 = '';

// 特定のレアキャラカウント（ハルシュト）
harushuto_count = 0;
}


//----------------
//読み込み後の処理
//----------------
$(function() {
	//----------------
	// 1回スカウトする
	//----------------
	$(".button_1").click( function() {
		scout_click(1);
	});
	//-----------------
	// 11回スカウトする
	//-----------------
	$(".button_11").click( function() {
		scout_11_count++;
		scout_click(11);
	});
	//------------------
	// 110回スカウトする
	//------------------
	$(".button_110").click( function() {
		scout_11_count += 10;
		scout_click(110);
	});
	//-------------------
	// 1100回スカウトする
	//-------------------
	$(".button_1100").click( function() {
		scout_11_count += 100;
		scout_click(1100);
	});
	//--------------------
	// 11000回スカウトする
	//--------------------
	$(".button_11000").click( function() {
		scout_11_count += 1000;
		scout_click(11000);
	});
	//---------------------
	// 110000回スカウトする
	//---------------------
	$(".button_110000").click( function() {
		scout_11_count += 10000;
		scout_click(110000);
	});
	//-----------
	// 初期化する
	//-----------
	$('.button_initialization').click( function() {
		initialization();
	});
});
</script>

<style>

.button_1, .button_11, .button_110, .button_1100, .button_11000, .button_110000 {
    float: left;
    margin: 0 5px 5px;
}


.button_1 {
   background-color: seashell;
    border: 1px solid #888;
    border-radius: 3px;
    color: #202020;
    cursor: pointer;
    display: inline;
    font-size: 82%;
    font-weight: bold;
    padding: 10px;
}
.button_1::before {
	content: "スカウト×1";
}


.button_11 {
   background-color: gold;
    border: 1px solid #888;
    border-radius: 3px;
    color: #202020;
    cursor: pointer;
    display: inline;
    font-size: 82%;
    font-weight: bold;
    padding: 10px;
}
.button_11::before {
	content: "スカウト×11";
}

.button_110 {
   background-color: gold;
    border: 1px solid #888;
    border-radius: 3px;
    color: #202020;
    cursor: pointer;
    display: inline;
    font-size: 82%;
    font-weight: bold;
    padding: 10px;
}
.button_110::before {
	content: "スカウト×110!（非公式）";
}

.button_1100 {
   background-color: gold;
    border: 1px solid #888;
    border-radius: 3px;
    color: #202020;
    cursor: pointer;
    display: inline;
    font-size: 82%;
    font-weight: bold;
    padding: 10px;
}
.button_1100::before {
	content: "スカウト×1100!!（非公式）";
}

.button_11000 {
   background-color: gold;
    border: 1px solid #888;
    border-radius: 3px;
    color: #202020;
    cursor: pointer;
    display: inline;
    font-size: 82%;
    font-weight: bold;
    padding: 10px;
}
.button_11000::before {
	content: "スカウト×11000!!!（非公式）";
}

.button_110000 {
   background-color: gold;
    border: 1px solid #888;
    border-radius: 3px;
    color: #202020;
    cursor: pointer;
    display: inline;
    font-size: 82%;
    font-weight: bold;
    padding: 10px;
}
.button_110000::before {
	content: "スカウト×110000!!!!（非公式）";
}
.button_initialization {
    color: #202020;
    cursor: pointer;
    display: inline;
    font-size: 82%;
    padding: 10px;
}




</style>

<div class="m_t_30 m_b_30 clearfix">
	<div class="button_1 o_8"></div>
	<div class="button_11 o_8"></div>


	<div class="button_110 o_8"></div>
	<div class="button_1100 o_8"></div>
	<div class="button_11000 o_8"></div>
	<div class="button_110000 o_8"></div>
	<div class="button_initialization o_8">初期化する</div>
</div>

<div class="scout_view">ここに結果が表示されます</div>



2326 ×0.043%
1,057,500円
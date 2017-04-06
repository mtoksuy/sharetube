<?php
/**************************************************

	GETメソッドのリクエスト [ベアラートークン]

**************************************************/

// 設定項目
$api_key    = "q7Zh6nXxeWElYBEE3GGnWhkzk" ;	                          // APIキー
$api_secret = "2ZbLjcWl8eNOqRYQN12Rs67EOoZUTT0Ra3fPPAWoWyuyOxhCwf" ;	// APIシークレット

// クレデンシャルを作成
$credential = base64_encode( $api_key . ":" . $api_secret ) ;
//var_dump($credential);

// リクエストURL
$request_url = "https://api.twitter.com/oauth2/token" ;

// リクエスト用のコンテキストを作成する
$context = array(
	"http" => array(
		"method" => "POST" , // リクエストメソッド
		"header" => array(			  // ヘッダー
			"Authorization: Basic " . $credential ,
			"Content-Type: application/x-www-form-urlencoded;charset=UTF-8" ,
		) ,
		"content" => http_build_query(	// ボディ
			array(
				"grant_type" => "client_credentials" ,
			)
		) ,
	) ,
) ;


/*
// cURLを使ってリクエスト
$curl = curl_init() ;
curl_setopt( $curl, CURLOPT_URL , $request_url ) ;	// リクエストURL
curl_setopt( $curl, CURLOPT_HEADER, true ) ;	// ヘッダーを取得する 
curl_setopt( $curl, CURLOPT_CUSTOMREQUEST , $context["http"]["method"] ) ;	// メソッド
curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER , false ) ;	// 証明書の検証を行わない
curl_setopt( $curl, CURLOPT_RETURNTRANSFER , true ) ;	// curl_execの結果を文字列で返す
curl_setopt( $curl, CURLOPT_HTTPHEADER , $context["http"]["header"] ) ;	// ヘッダー
curl_setopt( $curl, CURLOPT_POSTFIELDS , $context["http"]["content"] ) ;	// リクエストボディ
curl_setopt( $curl, CURLOPT_TIMEOUT , 5 ) ;	// タイムアウトの秒数
$res1 = curl_exec( $curl ) ;
$res2 = curl_getinfo( $curl ) ;
curl_close( $curl ) ;

// 取得したデータ
$response = substr( $res1, $res2["header_size"] ) ;	// 取得したデータ(JSONなど)
$header = substr( $res1, 0, $res2["header_size"] ) ;	// レスポンスヘッダー (検証に利用したい場合にどうぞ)
*/
$response = file_get_contents( $request_url , false , stream_context_create( $context ) ) ;
// JSONを配列に変換する
$arr = json_decode( $response, true);

// 設定
// ベアートークン取得
$bearer_token = $arr['access_token'];
// リクエストURL
$request_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json'; // タイムライン用
$request_url = 'https://api.twitter.com/1.1/statuses/show.json';          // ツイート用

// パラメータ
$params = array(
	'id' => '847362860644614145',
//	'screen_name' => '@arayutw' ,
//	'count' => 10 ,
);

// パラメータがある場合
if ( $params ) {
	$request_url .= '?' . http_build_query( $params ) ;
}

// リクエスト用のコンテキスト
$context = array(
	'http' => array(
		'method' => 'GET' , // リクエストメソッド
		'header' => array(			  // ヘッダー
			'Authorization: Bearer ' . $bearer_token ,
		) ,
	) ,
) ;


/*
// cURLを使ってリクエスト
$curl = curl_init() ;
curl_setopt( $curl, CURLOPT_URL, $request_url ) ;	// リクエストURL
curl_setopt( $curl, CURLOPT_HEADER, true ) ;	// ヘッダーを取得する
curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, $context['http']['method'] ) ;	// メソッド
curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false ) ;	// 証明書の検証を行わない
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true ) ;	// curl_execの結果を文字列で返す
curl_setopt( $curl, CURLOPT_HTTPHEADER, $context['http']['header'] ) ;	// ヘッダー
curl_setopt( $curl, CURLOPT_TIMEOUT, 5 ) ;	// タイムアウトの秒数
$res1 = curl_exec( $curl ) ;
$res2 = curl_getinfo( $curl ) ;
curl_close( $curl ) ;

// 取得したデータ
$json = substr( $res1, $res2['header_size'] ) ;	// 取得したデータ(JSONなど)
$header = substr( $res1, 0, $res2['header_size'] ) ;	// レスポンスヘッダー (検証に利用したい場合にどうぞ)
*/


// [cURL]ではなく、[file_get_contents()]を使うには下記の通りです…
$json = @file_get_contents( $request_url , false , stream_context_create( $context ) ) ;

// JSONを変換
$obj = json_decode($json, true);
pre_var_dump($obj['extended_entities']['media'][0]['video_info']['variants'][1]['url']);


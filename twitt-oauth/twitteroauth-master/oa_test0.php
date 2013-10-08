<?php
require_once("twitteroauth/twitteroauth.php");

// OAuthアプリ登録で取得したConsumer keyを設定
$consumer_key="30MDc4kbpD1T1IVrw0qw";
// OAuthアプリ登録で取得したConsumer secretを設定
$consumer_secret="LyfPQewKoHH6XK2tKU19K1fhHGWK09jOtICyls8B9Q";
// OAuthトークン取得プログラムで取得したoauth_tokenを設定
$oauth_token="625521669-EDdZfjZ4MPjML3jFskUe5GPd9oZ1SyqYTaIB35P6";
// OAuthトークン取得プログラムで取得したoauth_token_secretを設定
$oauth_token_secret="qqp5SRbJQLDP8AbkpQ8FJ4YGXB9lVwj9Ry2SEOYJs0";

// プログラムの文字コードがUTF-8の場合はこのまま
$status = "This tweet was posted by machine.";
// プログラムの文字コードがSJISの場合はUTF-8に変換
//$status = mb_convert_encoding($status, "UTF-8", "SJIS");

// 発言を行うメソッドを指定
$method = "statuses/update";
// パラメータを指定（ここでは発言内容を指定）
$parameters = array("status" => $status);

// TwitterOAuthのインスタンスを生成
$twitter = new TwitterOAuth(
  $consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret
);

// Twitterに発言をPOST
$response = $twitter->post($method, $parameters);
$http_info = $twitter->http_info;
$http_code = $http_info["http_code"];

if($http_code == "200" && !empty($response)) {
  print "ok\n";
} else {
  print "ng\n";
}
?>
<?php
$start=microtime(true);
$consumer_key = "30MDc4kbpD1T1IVrw0qw";
$consumer_secret = "LyfPQewKoHH6XK2tKU19K1fhHGWK09jOtICyls8B9Q";
$access_token = "625521669-EDdZfjZ4MPjML3jFskUe5GPd9oZ1SyqYTaIB35P6";
$access_token_secret = "qqp5SRbJQLDP8AbkpQ8FJ4YGXB9lVwj9Ry2SEOYJs0";

$path = 'C:\Users/Hiroki_Kobayashi/Documents/develop/php/codebird-php-2.4.1/src/';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require("codebird.php");
print "require_once success!:$start";

Codebird::setConsumerKey($consumer_key, $consumer_secret);
$cb = Codebird::getInstance();
$cb->setToken($access_token, $access_token_secret);
//パラメータ
$params=array(
    'screen_name' => 'kobae964',
    'count' => 10
);
//取得
$tweets = (array) $cb->statuses_userTimeline($params);
array_pop($tweets);//最後の1件はステータスコードなので削除。
//出力
foreach($tweets as $tweet){
    print "<p>" . $tweet->text . "</p>";
}
$endtime=microtime(true);
?>
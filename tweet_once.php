<?php
$start=microtime(true);
$consumer_key = "30MDc4kbpD1T1IVrw0qw";
$consumer_secret = "LyfPQewKoHH6XK2tKU19K1fhHGWK09jOtICyls8B9Q";
$access_token = "625521669-EDdZfjZ4MPjML3jFskUe5GPd9oZ1SyqYTaIB35P6";
$access_token_secret = "qqp5SRbJQLDP8AbkpQ8FJ4YGXB9lVwj9Ry2SEOYJs0";

$path = 'C:\Users/Hiroki_Kobayashi/Documents/develop/php/codebird-php-2.4.1/src/';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require("codebird.php");

\Codebird\Codebird::setConsumerKey($consumer_key, $consumer_secret);
$cb = \Codebird\Codebird::getInstance();
$cb->setToken($access_token, $access_token_secret);
//パラメータ 
$params=array( 
    'status' => '富士山頂なーｗｗｗｗ',
    'lat' => 35.36000,
    'long' => 138.730000,
    'display_coordinates' => true,
);
//tweet(status_update)
$result = (array) $cb->statuses_update($params);
//出力
print_r ($result);
$endtime=microtime(true);
print "time:".($endtime-$start)." sec<br/>\r\n";
?>
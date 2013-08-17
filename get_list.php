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


$result=$cb->lists_list(array("screen_name"=>"kobae964"));
$msg="";
foreach($result as $row){
	if($row->user->screen_name==='kobae964')
		continue;
	var_dump($row);
	$msg.='username=@'.$row->user->screen_name."\r\n";
	$msg.='listname='.$row->name."\r\n";
	print("<br/>\r\n");
}
$status=$cb->statuses_update(array('status'=>$msg,));


$end=microtime(true);

print("time:".($end-$start)." sec.<br/>\r\n");
?>


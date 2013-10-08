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


//応答する時間(分)
$maxmin=15;

// TwitterOAuthのインスタンスを生成
$to = new TwitterOAuth(
  $consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret
);

function get_day($year,$month,$date)
{
	if( ($year<1 || $year >40000) || (1>$month ||$month>12) || (1>$date || $date >31))
		return array(0,0);
	$year%=400;
	$leap=($year%4==0 && $year%100!=0)||($year==0);
	$lbef2=$leap && $month <= 2;
	$table=array(0,3,3,6,1,4,6,2,5,0,3,5);
	$mmax=array(
	31,28+($leap?1:0),31,
	30,31,30,
	31,31,30,
	31,30,31);
	if ($date > $mmax[$month-1])
	{
		return array(2,0);
	}
	$ret=(6+$date+$table[$month-1]+$year);
	$ret+=floor($year/4)-floor($year/100)-($lbef2?1:0);
	$ret%=7;
	return array(1,$ret);
}
$days=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
$days_jpn=array("日","月","火","水","木","金","土");

//Notification
$to->post("statuses/update",
array("status"=>
"【お知らせ】今から".$maxmin."分の間、私(@kobae964)に向かって年月日をつぶやくと、その曜日が返信されます。対応しているのは西暦1年～40000年です。思い出に残っている日の曜日を調べてみましょう!【bot】"
)
);





$result = 
$to->OAuthRequest(
	"http://api.twitter.com/1/statuses/mentions.xml",
	"GET",
	array("count"=>"1"));
//扱いやすくする
$xml = simplexml_load_string($result);
$last="";
//foreachを使い処理をする
foreach( $xml->status as $value ){
	$last = $value->id.""; //個別発言のステータスナンバー
}
echo "Last ID=";
echo $last;
echo "\r\n";
$replied=array();
$minute=0;
while($minute<=$maxmin)
{
	$second=0;
	echo "**********          Minute=".$minute."    ********\r\n";
	//APIを呼び出す（今回はリプライを10件取得する）
	$result = 
	$to->OAuthRequest(
		"http://api.twitter.com/1/statuses/mentions.xml",
		"GET",
		array("count"=>"10","since_id"=>$last));
	//扱いやすくする
	$xml = simplexml_load_string($result);
	//foreachを使い処理をする
	foreach( $xml->status as $value ){
		$status_number = $value->id; //個別発言のステータスナンバー
		var_dump($status_number);
		echo "Reply to:".$status_number."\r\n";
		$text = $value->text;    //発言内容
		$screen_name = $value->user->screen_name; //発言者のtwitterID
		if(in_array($status_number[0],$replied))
		{
			echo "id=".$status_number[0]."was already replied.\r\n";
			continue;
		}
		$replied[]=$status_number[0];
		if(preg_match("/@kobae964[^0-9]*([0-9]+)[^0-9]+([0-9]+)[^0-9]+([0-9]+)/",$text,$dat))
		{
			if(preg_match("/bot_rep/",$text))
			{
				continue;
			}
			$day=get_day($dat[1],$dat[2],$dat[3]);
			if($day[0]==0)continue;
			$msg="@".$screen_name." ".$dat[1]."年".$dat[2]."月".$dat[3]."日は";
			if($day[0]==1)
			{
				$msg.=$days_jpn[$day[1]]."曜日です。";
			}
			else
			{
				$msg.="存在しない日付です。";
			}
			$msg.=" bot_reply";
			$result=$to->post("statuses/update",
			array(
			"status" => $msg,
			"in_reply_to_status_id" => "".$status_number,
			));
		}
	}
	if($minute==$maxmin)
		break;
	for(;$second<60;$second++)
	{
		echo $minute."m".$second."s\r\n";
		sleep(1);
	}
	$minute++;
	if($minute%30==0 && $minute<$maxmin)
	{
		$to->post("statuses/update",array("status"=>"【お知らせ】あと".($maxmin-$minute)."分です。"));
	}
}

$to->post("statuses/update",array("status"=>"【お知らせ】終わりました。 (botがお送りしました)"));
?>
<?php
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
echo get_day(1,12,25)[1]."\r\n";

?>
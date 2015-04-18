<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

/**
 * 云签到内部计划任务
 * [重新尝试签到出错的贴吧]
 */

function cron_system_sign_retry() {
    echo "<br><br><br><br><br>进入计划重签：";
	global $i;

	$today = date('Y-m-d');

	$sign_again = unserialize(option::get('cron_sign_again'));
	if ($sign_again['lastdo'] != $today) {
		option::set('cron_sign_again',serialize(array('num' => 0, 'lastdo' => $today)));
	}
    echo "<br>today:".$today."======sign_again:";
    print_r($sign_again);
    echo"<br>";
//    print_r($i);
	foreach ($i['table'] as $value) {
        echo "<br>当前table为：".$value."<br>";
		misc::DoSign_retry($value);
	}
}

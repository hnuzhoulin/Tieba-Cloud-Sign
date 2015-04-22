<?php
define('SYSTEM_DO_NOT_LOGIN', true);
require dirname(__FILE__).'/init.php';
global $m,$today,$i;
ignore_user_abort(true);
set_time_limit(0);
echo __FILE__.".".__CLASS__.".".__FUNCTION__;
$cron_pw = option::get('cron_pw');
$cmd_pw = function_exists('getopt') ? getopt('',array('pw::')) : false;
if (!empty($cron_pw)) {
	if ((empty($_REQUEST['pw']) || $_REQUEST['pw'] != $cron_pw) && (empty($cmd_pw) || $cmd_pw['pw'] != $cron_pw)) {
		echo('计划任务执行失败：密码错误<br/><br/>你需要通过访问 <b>do.php?pw=密码</b> 才能执行计划任务');
	}
}
doAction('cron_1');
if (SYSTEM_PAGE == 'runcron') {
	$cron = isset($_GET['cron']) ? sqladds(strip_tags($_GET['cron'])) : msg('运行失败：计划任务未指定');
	$cpw  = option::get('cron_pw');

	$x    = $m->once_fetch_array("SELECT * FROM `".DB_PREFIX."cron` WHERE `name` = '{$cron}';");
	if (empty($x['id'])) {
		echo('运行失败：此计划任务不存在');
	}

	$log = cron::run($x['file'] , $x['name']);

	if ($x['freq'] == '-1') {
		cron::del($x['name']);
	} else {
		cron::aset($x['name'] ,
			array(
				'lastdo' => time(),
				'log'    => $log
			)
		);
	}
} else {
	$sign_multith = option::get('sign_multith');
	if (!isset($_GET['donnot_sign_multith']) && !empty($sign_multith) && function_exists('fsockopen')) {
		for ($ii=0; $ii < $sign_multith; $ii++) {
			sendRequest(SYSTEM_URL.'do.php?donnot_sign_multith&pw=' . $cron_pw);
		}
	}
		$return = '';
		if (option::get('cron_last_do_time') != $today) {
			option::set('cron_last_do_time',$today);
			option::set('cron_last_do','0');
		}
		cron::runall();
}
doAction('cron_2');
echo('本次计划任务完成');

<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
//特别警告：请勿使用记事本编辑！！！如果你正在使用记事本并且还没有保存，赶紧关掉！！！
//如果你已经用记事本保存了，请立即下载最新版的云签到包解压并覆盖本文件

//BAE/SAE/JAE的数据库地址，用户名，密码请参考相关文档

//MySQL 数据库地址，普通主机一般为localhost
define('DB_HOST','localhost');
//MySQL 数据库用户名
define('DB_USER','root');
//MySQL 数据库密码
define('DB_PASSWD','1qaz2wsx@mysql');
//MySQL 数据库名称(存放百度贴吧云签到的)
define('DB_NAME','tieba');
//MySQL 数据库前缀，建议保持默认
define('DB_PREFIX','tc_');

//请务必删掉下面这句，否则将每次转到安装页面
if(!file_exists('./setup/install.lock') && !defined('SYSTEM_DO_NOT_REMIND_INSTALL')) header('Location: ./setup/install.php');

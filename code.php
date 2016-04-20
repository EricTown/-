<?php
	//本地环境display_errors开启了,注销掉!
	ini_set('display_errors', 'Off');
	session_start();
	define('IN_TG',true);
include './include/global.func.php';
//第一个参数 int $_width 表示验证码的长度
// 第二个参数 int $_height 表示验证码的高度
//第三个参数  int $_rnd_code 表示验证码的位数
// 第四个参数 bool $_flag 表示验证码是否需要边框 
code();
?>
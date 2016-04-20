<?php
//防止恶意调用
if (!defined('IN_TG')){
	exit("Access Defined");
}
include 'global.func.php';
//
if (!function_exists('alert_back')) {
	exit('alert_back()函数不存在，请检查!');
}

/**
 * check_username表示检测并过滤用户名
 * @access public 
 * @param string $_string 受污染的用户名
 * @param int $_min_num  最小位数
 * @param int $_max_num 最大位数
 * @return string  过滤后的用户名 
 */
function check_username($_string,$_min_num,$_max_num){
	//去掉两边的空格
	$_string = trim($_string);
	
	//长度小于两位或者大于20位
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		alert_back('长度不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	
	//限制敏感字符
	$_char_pattern = '/[<>\'\"\ \　]/';
	if (preg_match($_char_pattern,$_string)) {
		alert_back('用户名不得包含敏感字符');
	}
	
	//限制敏感用户名
	$_mg[0] = '马化腾';
	$_mg[1] = '林观荣';
	$_mg[2] = '张君';
	//告诉用户，有哪些不能够注册
	foreach ($_mg as $value) {
		$_mg_string = null ;
		$_mg_string .= '[' . $value . ']' . '\n';
	}
	//这里采用的绝对匹配
	if (in_array($_string,$_mg)) {
		alert_back($_mg_string.'以上敏感用户名不得注册');
	}
	
	//将用户名转义输入
	return $_string;
}

/**
 * check_password验证密码
 * @access public
 * @param string $first_pass
 * @param string $end_pass
 * @param int $min_num
 * @return string $first_pass 返回一个加密后的密码
 */

function check_password($first_pass,$end_pass,$min_num=6) {
	//判断密码
	if (strlen($first_pass) < $min_num) {
		alert_back('密码不得小于'.$min_num.'位！');
	}
	
	//密码和密码确认必须一致
	if ($first_pass != $end_pass) {
		alert_back('密码和确认密码不一致！');
	}
	
	//将密码返回
	return sha1($first_pass);
}

/**
 * check_question 返回密码提示
 * @access public
 * @param string $_string
 * @param int $_min_num
 * @param int $_max_num
 * @return string $_string 返回密码提示
 */
function check_question($_string,$_min_num,$_max_num) {
	//长度小于4位或者大于20位
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		alert_back('密码提示不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	
	//返回密码提示
	return $_string;
}

/**
 *check_answer()
 *@access public 
 * @param string $_ques
 * @param string $_answ
 * @param int $_min_num
 * @param int $_max_num
 * @return $_answ
 */
function check_answer($_ques,$_answ,$_min_num,$_max_num) {
	//长度小于4位或者大于20位
	if (mb_strlen($_answ,'utf-8') < $_min_num || mb_strlen($_answ,'utf-8') > $_max_num) {
		alert_back('密码回答不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	
	//密码提示与回答不能一致
	if ($_ques == $_answ) {
		alert_back('密码提示与回答不得相同');
	}
	
	//加密返回
	return sha1($_answ);
}

/**
 * check_email() 检查邮箱是否合法
 * @access public
 * @param string $_string 提交的邮箱地址
 * @return string $_string 验证后的邮箱
 */

function check_email($_string) {
	//正则
	
	if (empty($_string)) {
		return null;	
	} else {
		if (!preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/",$_string)) {
			alert_back('邮件格式不正确！');
		}
	}
	
	return $_string;
}

/**
 * check_qq ....
 * @access public
 * @param int $_string
 * @return int $_string  QQ号码
 */

function check_qq($_string) {
	if (empty($_string)) {
		return null;
	} else {
		//123456
		if (!preg_match('/^[1-9]{1}[\d]{4,9}$/',$_string)) {
			alert_back('QQ号码不正确！');
		}
	}
	
	return $_string;
}

/**
 * check_tel ....
 * @access public
 * @param int $_string
 * @return int $_string  手机号码
 */

 function check_tel($_string){
 	if (empty($_string)) {
		return null;
	}else{
		if(!preg_match("/^1[34578]\d{9}$/", $_string)){
			alert_back('手机号码不正确！');
	}
	}
	return $_string;
 }



?>
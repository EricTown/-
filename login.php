<!DOCTYPE html>
<?php
session_start();
//定义常用,给页面进行授权
define('IN_TG',true);
header('Content-Type: text/html; charset=utf-8');
include './include/global.func.php';
//echo strlen(sha1('1234567'));
if ($_POST['action']=='login'){
	if(!($_POST['yzm']==$_SESSION['code']) ){
   alert_back('验证码错误!');
 }
 include 'conn.php';
 $username=$_POST['username'];
 $psw=sha1($_POST['password']);
 $check_query = mysql_query("select*from user where username='$username' limit 1");
/*echo "select*from user where username='$username' and password='$psw' limit 1";*/
 //var_dump ($check_query);
 $result = mysql_fetch_array($check_query);
 if (!$result) {
 	alert_back('用户名错误');
 }
 //如果用户输入密码错误中途10分钟之内没再输入错误密码,错误次数和时间清零
 if ($result['count']>0&&$result['count']<5&&strtotime($result['count_time'])<strtotime("-10 minute")) 
 {
 	mysql_query("update user set count = 0 and count_time=null where username='$username'");
 }
 //如果用户密码错误5次并且当前时间距离最后一次错误时间不够5分钟就限制登录
 if ($result['count']>=5&&strtotime($result['count_time'])>=strtotime("-5 minute")) {
 	exit('由于用户密码错误次数超过5次,限制用户登录');
 }
 if ($psw==$result['password']) {
 	//用户登录成功,清零错误时间和次数
 	mysql_query("update user set count = 0 , count_time=null where username='$username'");
 	$_SESSION['username'] = $username;  
    $_SESSION['id'] = $result['id'];  
    echo $username,' 欢迎你！<br />';  
    echo "点击此处<a href='user_center.php'>跳转用户中心</a><br />";
    echo '点击此处 <a href="login.php?action=logout">注销</a> 登录！<br />'; 
 }else {
 	mysql_query("update user set count = count+1 ,count_time = now() where username='$username'"); 
 	
 		// mysql_query("update user set count_time =now()  where username='$username'");
 	
 	alert_back('密码错误');
 	//var_dump($result);
 }
 //注销登录
if($_GET['action'] == "logout"){  
    unset($_SESSION['id']);  
    unset($_SESSION['username']);  
    echo '注销登录成功！点击此处 <a href="login.php">登录</a>';  
    exit;  
}  

}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户登录</title>
	<script type="text/javascript">
	window.onload=function(){
			var code=document.getElementById('code');
			code.onclick=function(){
		this.src='code.php?tm='+Math.random();
	};
};
	function InputCheck(Login)
{
  if (Login.user.value == "")
  {
    alert("用户名不可为空!");
    Login.user.focus();
    return (false);
  }
  if (Login.mima.value == "")
  {
    alert("必须要有登录密码!");
    Login.mima.focus();
    return (false);
  }
  }
	</script>
</head>
<body>
	<div id="login">
		<h2>用户登录</h2>
		<form method="post" name="Login" action="login.php" onSubmit="return InputCheck(this)">
		<input type="hidden"  name="action" value="login">
			<dl>
				
				<dd>用户名　:<input type="text" name="username" class="text" id="user"></dd><div id="uname"></div>
				<dd>密　　码:<input type="password" name="password" class="text" id="mima"></dd><div id="psw"></div>
				<dd>验证码　:<input type="text" name="yzm" class="text yzm"><img src="code.php" id="code"></dd>
				<dd><input type="submit" name="submit" class="submit" value="登录"></dd>
			</dl>
		</form>
		
	</div>
</body>
</html>
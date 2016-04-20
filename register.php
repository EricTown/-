<!DOCTYPE html>
<?php
session_start();
//定义常用,给页面进行授权
define('IN_TG',true);
header('Content-Type: text/html; charset=utf-8');
include'./include/register.func.php';
if ($_POST['action']=='register'){
//验证码是否正确
 if(!($_POST['yzm']==$_SESSION['code']) ){
   alert_back('验证码错误!');
 }
 	 $clean=array();
	 $clean['username']=check_username($_POST['username'],2,20);
	 $clean['sex'] = $_POST['sex'];
	 $clean['password']=check_password($_POST['password'],$_POST['notpassword']);
	 $clean['tel'] = check_tel($_POST['tel']);
	 $clean['email'] = check_email($_POST['email']);
	 $clean['qq'] = check_qq($_POST['qq']);
	 //print_r $clean;
	 $username=$clean['username'];
	 $sex=$clean['sex'];
	 $password=$clean['password'];
	 $tel=$clean['tel'];
	 $email=$clean['email'];
	 $qq=$clean['qq'];
 	

include 'conn.php';
$res=mysql_query("select*from user where username='$username' limit 1");
if(!mysql_fetch_array($res)){
$sql = "INSERT INTO 
	user
	(username,sex,password,tel,email,qq,restime)
	VALUES
	('$username','$sex','$password','$tel','$email','$qq',now())";
if(mysql_query($sql,$conn)){
	mysql_query("insert into user_role (username ,rolecode) values('$username','normal')");
    exit('用户注册成功！点击此处 <a href="login.php">登录</a>');
} else {
    echo '抱歉！添加数据失败：',mysql_error(),'<br />';
    echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
}
}else{
	alert_back('用户名已存在,请重试');
}
}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户注册</title>
	<script type="text/javascript">
		window.onload=function(){
			var code=document.getElementById('code');
			code.onclick=function(){
		this.src='code.php?tm='+Math.random();
	};
};
	</script>
</head>
<body>
	<div id="register">
		<h2>用户注册</h2>
		<form method="post" name="register" action="register.php">
		<input type="hidden"  name="action" value="register">
			<dl>
				<dt>注册信息填写</dt>
				<dd>用户名　:<input type="text" name="username" class="text"></dd>
				<dd>性　　别:<input type="radio" name="sex" value="男" checked="checked">男<input type="radio" name="sex" value="女">女</dd>
				<dd>密　　码:<input type="password" name="password" class="text"></dd>
				<dd>密码确认:<input type="password" name="notpassword" class="text"></dd>
				<dd>手机号码:<input type="text" name="tel" class="text"></dd>
				<dd>电子邮件:<input type="text" name="email" class="text"></dd>
				<dd>QQ号码:<input type="text" name="qq" class="text"></dd>
				<dd>验证码　:<input type="text" name="yzm" class="text yzm"><img src="code.php" id="code"></dd>
				<dd><input type="submit" name="submit" class="submit" value="注册"></dd>
			</dl>
		</form>
		
	</div>
</body>
</html>
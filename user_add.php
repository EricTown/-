<!DOCTYPE html>
<?php
	session_start();
//定义常用,给页面进行授权
define('IN_TG',true);
header('Content-Type: text/html; charset=utf-8');
$username=$_SESSION['username'];
//include 'conn.php';
//print_r($_SERVER);
include 'include/mysql.func.php';
		$sql="select 
				user_role.rolecode,role.roleid,role.rolecode,role.rolename,ro_prinfo.rolecode,ro_prinfo.prid,prinfo.prname
			from
				role,user_role,prinfo,ro_prinfo
			where
				username='$username'
			and
				role.rolecode=user_role.rolecode
			and
				user_role.rolecode = ro_prinfo.rolecode
			and
				ro_prinfo.prid = prinfo.prid
			";
			$r=mysql_query($sql);
			//var_dump ($r);
			while ($arr=mysql_fetch_assoc($r)) {
				$res[]=$arr;	
			}
			// echo $res[rolename];
			//联合查询结果集合
			foreach ($res as $k=> $v) {
				
				$rolename=$v['rolename'];
				$roleid=$v['roleid'];
				$iteam[]= $v['prname'];
				
			}
			// print_r($roleid);
			// exit;
	if (!in_array("增加", $iteam)) {
			exit('权限不够,限制访问');
		}
	$user_res=mysql_query("select username from user");
	while ($arr_res=mysql_fetch_assoc($user_res)) {
		$arr[]=$arr_res;
	}
	include './include/register.func.php';
	if ($_POST['action']=='user_add'){
		if(!($_POST['yzm']==$_SESSION['code']) ){
   alert_back('验证码错误!');
 }
 	$clean=array();
 	$clean['username']=check_username($_POST['username'],2,20);
	 $clean['sex'] = $_POST['sex'];
	 $clean['rolename']=$_POST['rolename'];
	 $clean['password']=check_password($_POST['password'],$_POST['notpassword']);
	// print_r($clean);
	// exit;
	$res=mysql_query("select*from user where username='{$clean['username']}' limit 1");
if(!mysql_fetch_array($res)){
$sql = "INSERT INTO 
	user
	(username,sex,password,restime)
	VALUES
	('{$clean['username']}','{$clean['sex']}','{$clean['password']}',now())";
if(mysql_query($sql,$conn)){
	mysql_query("insert into user_role (username ,rolecode) values('{$clean['username']}','{$clean['rolename']}')");
    exit('添加成功！点击此处 <a href="login.php">登录</a>,<a href="user_center.php">用户中心</a>');
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
	<title>新增用户</title>
	<script type="text/javascript">
	window.onload=function(){
			var code=document.getElementById('code');
			code.onclick=function(){
		this.src='code.php?tm='+Math.random();
	};
};
	function InputCheck(form)
{
  if (form.user.value == "")
  {
    alert("用户名不可为空!");
    form.user.focus();
    return (false);
  }
  if (form.mima.value == "")
  {
    alert("必须要有登录密码!");
    form.mima.focus();
    return (false);
  }
  }
	</script>
</head>
<body>
<div>
	<form action="user_add.php" name="form" method="post" onSubmit="return InputCheck(this)">
		<input type="hidden"  name="action" value="user_add">
		<dl>
			<dt>添加用户</dt>
			<dd>用户名　:<input type="text" name="username" class="text"></dd>
			<dd>性　　别:<input type="radio" name="sex" value="男" checked="checked">男<input type="radio" name="sex" value="女">女</dd>
			<dd>用户角色:
			<?php 
			switch ($roleid) {
				case '1':
					echo "
					<select name='rolename'>
					<option selected='' value='admin'>管理员</option>
					<option  value='normal'>普通用户</option>
					</select>
					";
					
					break;
				case '2':
					echo "<select name='rolename'>
					<option selected='' value='normal'>普通用户</option>
					</select>";
					break;
				default:
					# code...
					break;
			}
			?>
			</dd>
			<dd>密　　码:<input type="password" name="password" class="text"></dd>
			<dd>密码确认:<input type="password" name="notpassword" class="text"></dd>
			<dd>验证码　:<input type="text" name="yzm" class="text yzm"><img src="code.php" id="code"></dd>
			<dd><input type="submit" name="submit" class="submit" value="提交"></dd>
		</dl>
	</form>
</div>

	
</body>
</html>
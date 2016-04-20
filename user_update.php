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
	if (!in_array("删除", $iteam)) {
			exit('权限不够,限制访问');
		}
	$user_res=mysql_query("select username from user");
	while ($arr_res=mysql_fetch_assoc($user_res)) {
		$arr[]=$arr_res;
	}
	if ($_POST) {
		$update_code=$_POST['rolecode'];
		$update_name=$_POST['username'];
		// echo "$delete_name";
		// exit;
		$update_sql="update user_role set rolecode='$update_code' where username='$update_name'";
		if(mysql_query($update_sql)){
			exit('用户更改成功,点击此处 <a href="javascript:history.back(-1);">返回</a>');
		}else {
		    echo '抱歉！添加数据失败：',mysql_error(),'<br />';
		    echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
		}
			}
	?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户管理_删除</title>
	<div>
		欢迎你,<?php echo "尊敬的<font color='red'>".$username."</font>".$rolename; ?>
</div>
	<div>
		<center>
			<table style="border:dotted;border-color:#F06">
			<caption>用户列表</caption>
			<tr><th>用户</th><th>用户角色</th><th style="width:600px;">权限信息</th><th>更改用户角色</th></tr>
		<?php
		
				foreach ($arr as $k => $v) {
				
				$new_sql="select user_role.rolecode,role.rolename
				from
				user_role,role
			where
				username='{$v['username']}'
				and 
				role.rolecode=user_role.rolecode
			
			";
			$new_r=mysql_query($new_sql);
			while ( $arr=mysql_fetch_assoc($new_r)) {
				$new_res[]=$arr;
			}
				
			//print_r ($new_res);
			// echo $res[rolename];
			//联合查询结果集合并
			foreach ($new_res as $key=> $val) {
				
				$new_rolename=$val['rolename'];
				
				
			}
			$v_name=$v['username'];
				echo "<tr><td>".$v_name."</td><td>".$new_rolename."</td><td>";
				$arr_result=user_select_prname($v['username']);
				foreach ($arr_result as $k => $v) {
					if ($username==$v_name) {
							echo "<a href='$v'>";
							echo $k ;
							echo "</a>";
							echo "&nbsp;&nbsp;&nbsp;";
					}else{
						//echo "<a href='$v'>";
					echo $k ;
					//echo "</a>";
					echo "&nbsp;&nbsp;&nbsp;";
					}
					
				}

				echo "</td><td>";
				// echo "<form action='user_update.php' method='post'>";
				// 	if($v_name=='管理员'){
				// 		echo '<dd><input type="radio" name="rolename" value="admin" checked="checked">管理员<input type="radio" name="rolename" value="normal">普通用户</dd>';
					//echo "</form>";
			
			if ($new_rolename!='超级管理员') {
					if ($new_rolename=='管理员') {
						echo "<form action='user_update.php' method='post' >";
						echo "
						<input type='hidden' name='username' value=".$v_name.">
						<input type='radio' name='rolecode' value='admin' checked='checked'>管理员<input type='radio' name='rolecode' value='normal'>普通用户
						<input type='submit' value='修改'>";
						echo "</form>";
						
					}else{
						echo "<form action='user_update.php' method='post' >";
						echo "
						<input type='hidden' name='username' value=".$v_name.">
						<input type='radio' name='rolecode' value='admin' >管理员<input type='radio' name='rolecode' value='normal' checked='checked'>普通用户
						<input type='submit' value='修改'>
							
						";
						echo "</form>";
					}
				}
				
				echo "</td></tr>";
			}
			?>

				
			</table>
		</center>
	</div>

</head>
<body>
	
</body>
</html>
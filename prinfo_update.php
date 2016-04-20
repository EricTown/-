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
	if (!in_array("角色权限管理", $iteam)) {
			exit('权限不够,限制访问');
		}
	//获取用户名
	// $user_res=mysql_query("select username from user");
	// while ($arr_res=mysql_fetch_assoc($user_res)) {
	// 	$arr[]=$arr_res;
	// }
	
	?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>角色权限更改</title>
</head>
<body>
<center>
			<table style="border:dotted;border-color:#F06">
			<caption>角色列表</caption>
			<tr><th>角色</th><th style="width:600px;">权限信息</th><th>更改权限</th></tr>
			<tr><td>管理员</td><td>
				<?php 
					$pr_sql="select
					role.rolecod,ro_prinfo.rolecode,ro_prinfo.prid,prinfo.prname,prinfo.prurl
					from role,ro_prinfo,prinfo
					where
					rolename='管理员'
					and
					ro_prinfo.rolecode=role.rolecode
					and
					prinfo.prid=ro_prinfo.prid
					";
					$pr=mysql_query($pr_sql);
			var_dump ($pr);
			exit;
			while ($arr=mysql_fetch_assoc($pr)) {
				$pr_res[]=$arr;	
			}
			var_dump ($pr_res);
			
			// echo $res[rolename];
			//联合查询结果集合并
			foreach ($pr_res as $k=> $v) {
				// echo "<a href='$v['prurl']'>";
				echo $v['prname'];
				echo "</a>";
				echo "&nbsp;&nbsp;&nbsp;";
				
				//$iteam[$v['prname']]= $v['prurl'];
				
			}

			
				?>
			</td>

			</tr>

				
			</table>
		</center>
	</div>
	
</body>
</html>
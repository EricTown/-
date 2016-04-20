<!DOCTYPE html>
<?php
	session_start();
//定义常用,给页面进行授权
define('IN_TG',true);
header('Content-Type: text/html; charset=utf-8');
$username=$_SESSION['username'];
include 'conn.php';
$sql="select 
				user_role.rolecode,role.rolecode,role.rolename,ro_prinfo.rolecode,ro_prinfo.prid,prinfo.prname,prinfo.prurl
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
			//联合查询结果集合并
			foreach ($res as $k=> $v) {
				
				$rolename=$v['rolename'];
				
				$iteam[$v['prname']]= $v['prurl'];
				}	
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户中心</title>
</head>
<body>
	<div>

		<?php
			
			echo "尊敬的<font color='red'>".$username."</font>".$rolename;
			echo "<br />";
			echo "在本站您拥有以下权限:";
			foreach ($iteam as $k => $v) {
				echo'<li>';
				echo "<a href='$v'>";
				echo $k ;
				echo "</a>";
				echo "</li>";
			}
				?>
					
				
			
	</div>
</body>
</html>
<?php
if (!defined('IN_TG')){
	exit("Access Defined");
}	
	header('Content-Type: text/html; charset=utf-8');

	include 'conn.php';
/**
 * user_select_prname 查询用户权限
 * @access public 
 * @param string $username 用户名
 * @return array   
 */
	function user_select_prname($username){
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
				
				
				
				$iteam[$v['prname']]= $v['prurl'];
				
			}
			return $iteam;
	}
	//exit;
	 //print_r (select_prname('小明'));

	/**
	 * role_select_prname() 查询用户权限
	 * @access public 
	 * @param string $username 用户名
	 * @return array   
	 */
	function role_select_prname($rolename)
	{
		$sql="select role.rolecode,ro_prinfo.prid,prinfo.prname,prinfo.prurl
		form role,ro_prinfo,prinfo
		where
		role.rolename='$rolename'
		and
		ro_prinfo.rolecode=role.rolecode
		and
		prinfo.prid=ro_prinfo.prid
		";
		$r=mysql_query($sql);
			//var_dump ($r);
			while ($arr=mysql_fetch_assoc($r)) {
				$res[]=$arr;	
			}
			// echo $res[rolename];
			//联合查询结果集合并
			foreach ($res as $k=> $v) {
				
				
				
				$iteam[$v['prname']]= $v['prurl'];
				
			}
			return $iteam;
	}
	/**
	 * role_select_username() 查询用户名
	 * @access public 
	 * @param string $rolename 用户角色名
	 * @return array   
	 */
	function role_select_username($rolename)
	{
		$sql="select role.rolecode,user_role.username
		from
		role,user_role
		where
		role.rolename='$rolename'
		and
		user_role.rolecode=role.rolecode
		";
		$r=mysql_query($sql);
			//var_dump ($r);
			while ($arr=mysql_fetch_assoc($r)) {
				$res[]=$arr;	
			}
			foreach ($res as $k=> $v) {

				$iteam[]= $v['username'];
				
			}
			return $iteam;
	}
  ?>
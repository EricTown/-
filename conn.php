<?php
	$conn=mysql_connect("localhost",'root','root');
	if (!$conn){
    			die("连接数据库失败：" . mysql_error());
				}
    mysql_select_db('test',$conn);
    mysql_query("set character set 'utf8'");
	mysql_query("set names 'utf8'");
	
?>
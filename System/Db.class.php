<?php
//Mysqli数据库操作类
class db {
	//连接数据库
	function __construct($host,$user,$pwd,$name,$port){
		$this->mysqli = mysqli_connect($host,$user,$pwd,$name,$port);
		if(mysqli_connect_errno() > 0){
			exit('数据库连接失败['.mysqli_connect_errno().']:'.mysqli_connect_error());
		}
		mysqli_query($this->mysqli,"set names 'utf8'");
	}
	
	//查询并获取结果集
	function get_row($sql){
		$result = mysqli_query($this->mysqli,$sql);
		return mysqli_fetch_assoc($result);
	}
	//查询数据库
	function query($sql){
		return mysqli_query($this->mysqli,$sql);
	}
	
	//获取结果集
	function fetch($sql){
		return mysqli_fetch_assoc($sql);
	}
	
	//获取循环后的结果集
	function rs($sql){
		$r = mysqli_query($this->mysqli,$sql);
		while($row = mysqli_fetch_assoc($r)){
			$rows[] = $row;
		}
		return $rows;
	}
	
	//获取数据表的数据条数
	function count($sql){
		$result = mysqli_query($this->mysqli,$sql);
		$count = mysqli_fetch_array($result);
		return $count[0];
		//使用方法例如:$db->count("SELECT count(*) FROM ssnh_users");
	}
	
	//获取错误编号与错误提示信息
	function error(){
		$error = mysqli_error($this->mysqli);
		$errno = mysqli_errno($this->mysqli);
		return '['.$errno.']:'.$error;
		}
	
	//关闭数据库连接
	function close(){
		$do = mysqli_close($this->mysqli);
		return $do;
	}
}
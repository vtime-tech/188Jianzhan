<?php
/**
 * Copyright (C) <2018>  辽宁微时光科技有限公司
 * Author 酸奶(qq348069510)
 * Email admin@vtimecn.com or 348069510@qq.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

error_reporting(0);//关闭报错
header("Content-type: text/html; charset=utf-8");//设置编码
date_default_timezone_set('PRC');//设置时区
define('VERSION', '2.10');
define('WWWROOT', dirname(__FILE__));
require_once(WWWROOT.'/../config.php');//数据库信息配置文件
require_once(WWWROOT.'/Db.class.php');//数据库操作类文件
if(is_file(WWWROOT.'/Safe/360webscan.php')){
    require_once(WWWROOT.'/Safe/360webscan.php');//360网站卫士
}

//环境判断
function checkfunc($f,$m = false) {
	if (function_exists($f)) {
		return '<span class="label label-success">支持</span>';
	} else {
		if ($m == false) {
			return '<span class="label label-danger">不支持</span>';
		} else {
			return '<span class="label label-danger">不支持</span>';
		}
	}
}

function checkclass($f,$m = false) {
	if (class_exists($f)) {
		return '<span class="label label-success">可用</span>';
	} else {
		if ($m == false) {
			return '<span class="label label-danger">不可用</span>';
		} else {
			return '<span class="label label-danger">不可用</span>';
		}
	}
}
//连接数据库
$db = new db($Mysql['host'],$Mysql['user'],$Mysql['pwd'],$Mysql['name'],$Mysql['port']);

//获取系统配置
$sql = $db->query('SELECT * FROM kaxiao_config');
while($row = $db->fetch($sql)){
	$config[$row['vkey']] = $row['value'];
}

//获取用户信息
$cookie = $_COOKIE['kaxiao_sid'];
if(preg_match('/^[0-9a-z]{32}$/i',$cookie)){
if($userrow = $db->get_row("SELECT * FROM kaxiao_admin WHERE `cookie` =  '{$cookie}' LIMIT 1")){
		$islogin = 1;
    }
}

function curl_get($url)
{
$ch=curl_init($url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn; R815T Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1');
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$content=curl_exec($ch);
curl_close($ch);
return($content);
}
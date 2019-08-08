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

require_once('../System/Common.php');
if (!$islogin){
	exit("<script language='javascript'>alert('你还未登录账号,请前往登录页面进行登录!');window.location.href='login.php';</script>");
}
if ($_GET['sid']){
    $id = $_GET['sid'];
    if (!$id){
        exit("<script language='javascript'>alert('sid参数不能为空!');</script>");
    }
    $siteinfo = $db->get_row("SELECT * FROM kaxiao_site WHERE sid='{$id}' LIMIT 1");
    if ($siteinfo['uid'] != $userrow['uid'] and $userrow['uid'] != 1){
        exit("<script language='javascript'>alert('无效操作!');window.location.href='domain.php?sid=$id';</script>");
    }else{
        $domainlist = $siteinfo['optdomain'];
		if(!$domainlist){
			$domainlist = array();
		}else{
			if(strstr($domainlist,",")){
				$domainlist = explode(',',$domainlist);
			}else{
				$domainlist = array($siteinfo['optdomain']);
			}
		}
    }
}else{
	exit("<script language='javascript'>alert('id参数不能为空!');</script>");
}
if ($_GET['sid'] and $_GET['domain']){
    $id = $_GET['sid'];
	$domain = $_GET['domain'];
    if(!$id){
        exit("<script language='javascript'>alert('id参数不能为空!');window.location.href='domain.php?sid=$id';</script>");
    }
    $siteinfo = $db->get_row("SELECT * FROM kaxiao_site WHERE sid='{$id}' LIMIT 1");
    if($siteinfo['uid'] != $userrow['uid'] and $userrow['uid'] != 1){
        exit("<script language='javascript'>alert('无效操作!');window.location.href='domain.php?sid=$id';</script>");
    }else{
		if($_GET['type']){
			if($_GET['type'] == 'del'){
				$epurl = $config['epurl'];
				$username = $siteinfo['domain'];
				$password = $siteinfo['passwd'];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://'.$epurl.'/vhost/index.php?c=session&a=login');
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('username' => $username, 'passwd' => $password)));
				curl_setopt($ch, CURLOPT_HEADER, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
				$p = curl_exec($ch);
				curl_close($ch);
				preg_match('/PHPSESSID=(.{26})/i', $p, $matches);
				$cookie = $matches[1];

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://'.$epurl.'/vhost/index.php');
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie: PHPSESSID=' . $cookie));
				$p2 = curl_exec($ch);
				curl_close($ch);
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://'.$epurl.'/vhost/index.php?c=domain&a=del');
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('domain' => $domain)));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie: PHPSESSID=' . $cookie));
				$p3 = curl_exec($ch);
				curl_close($ch);
				if($p3 == "成功"){
					$num = count($domainlist);
					$domainstr = $siteinfo['optdomain'];
					if($num == 1){
						$db->query("UPDATE `kaxiao_site` SET `optdomain` = '' WHERE `sid` = '{$id}';");
					}else{
						$domainstr = str_replace(','.$domain,'',$domainstr);
						$db->query("UPDATE `kaxiao_site` SET `optdomain` = '{$domainstr}' WHERE `sid` = '{$id}';");
					}
					exit("<script language='javascript'>alert('删除成功');window.location.href='domain.php?sid=$id';</script>");
				}else{
					exit("<script language='javascript'>alert('删除失败,可能未绑定该域名');history.go(-1);</script>");
				}
			}
		}
		$epurl = $config['epurl'];
		$username = $siteinfo['domain'];
		$password = $siteinfo['passwd'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://'.$epurl.'/vhost/index.php?c=session&a=login');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('username' => $username, 'passwd' => $password)));
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		$p = curl_exec($ch);
		curl_close($ch);
		preg_match('/PHPSESSID=(.{26})/i', $p, $matches);
		$cookie = $matches[1];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://'.$epurl.'/vhost/index.php');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie: PHPSESSID=' . $cookie));
		$p2 = curl_exec($ch);
		curl_close($ch);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://'.$epurl.'/vhost/index.php?c=domain&a=add&domain=' . urlencode($domain) . '&subdir=%2Fwwwroot');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie: PHPSESSID=' . $cookie));
		$p3 = curl_exec($ch);
		curl_close($ch);
		if($p3 == "成功"){
			array_push($domainlist,$domain);
			$num = count($domainlist);
			$domainstr = $siteinfo['optdomain'];
			if($num == 1){
				$domainstr = $domainlist[0];
				$db->query("UPDATE `kaxiao_site` SET `optdomain` = '{$domainstr}' WHERE `sid` = '{$id}';");
			}else{
				$domainstr = $domainstr.','.$domain;
				$db->query("UPDATE `kaxiao_site` SET `optdomain` = '{$domainstr}' WHERE `sid` = '{$id}';");
			}
		}else{
			 exit("<script language='javascript'>alert('绑定失败,可能该域名已被绑定或者密码信息错误');history.go(-1);</script>");
		}
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8" />
  <title>站点域名信息</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="https://cdn.css.net/libs/animate.css/3.5.1/animate.css" type="text/css" />
  <link rel="stylesheet" href="https://cdn.css.net/libs/font-awesome/4.5.0/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="https://cdn.css.net/libs/simple-line-icons/2.2.4/css/simple-line-icons.css" type="text/css" />
  <link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/html/css/font.css" type="text/css" />
  <link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/html/css/app.css" type="text/css" />
  <link rel="stylesheet" href="https://admin.down.swap.wang/assets/plugins/toastr/toastr.min.css" type="text/css" />
</head>
<body>
<div class="bg-light lter b-b wrapper-md hidden-print">
<div class="panel panel-default">
    <div class="panel-heading font-bold">                  
     域名添加
    </div>
    <div class="panel-body">
       <form id="submit" method="get" class="form-inline ng-pristine ng-valid ng-submitted">
        <div class="form-group">
          <label class="sr-only" for="exampleInputEmail2">输入域名</label>
           <input type="text" name="domain" class="form-control" />
        </div>
        <input type="hidden" name="type" value="add">
        <input type="hidden" name="sid" value="<?=$id?>">
        <span ng-controller="ModalDemoCtrl" class="ng-scope">
            <input type="submit" value="添加"  class="btn btn-success">  
        </span>
      </form>
    </div>
  </div>

<div class="panel panel-default">
    <div>
      <table class="table" >
        <thead>
          <tr>
            <th>域名</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
		  <tr>
		  <?php foreach($domainlist as $d){ ?>
            <td><a href="<?=$d?>" target="_blank"><?=$d?></a></td>
            <td><a class="btn btn-xs btn-danger" href="?type=del&domain=<?=$d?>&sid=<?=$id?>">删除</a></td>
          </tr>
		  <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
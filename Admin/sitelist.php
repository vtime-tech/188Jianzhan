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
 
$title = "网站列表";
require_once('./head.php');
$p = is_numeric($_GET['p']) ? $_GET['p'] : '1';
$pp=$p+7;
$pagesize=10;
$start=($p-1)*$pagesize;
if ($userrow['uid'] == 1){
    $sites=$db->rs("SELECT * FROM kaxiao_site ORDER BY sid DESC LIMIT $start,$pagesize");
    $pages=ceil($db->count('SELECT count(*) FROM kaxiao_site')/$pagesize);
}else{
    $sites=$db->rs("SELECT * FROM kaxiao_site WHERE uid='{$userrow['uid']}' ORDER BY sid LIMIT $start,$pagesize");
    $pages=ceil($db->count("SELECT count(*) FROM kaxiao_site uid='{$userrow['uid']}'")/$pagesize);
}
if($pp>$pages){
    $s = 1;
    $pp=$pages;
    if($pages > 8){
        $s = $pages - $p;
        $s = 7 - $s;
        $s = $p - $s;
    }
}else{
    $s = $p;
}
if($p==1){
    $prev=1;
}else{
    $prev=$p-1;
}
if($p==$pages){
    $next=$p;
}else{
    $next=$p+1;
}
$authcode = $config['authcode'];
$rand = rand(1,9999);
$do = 'update_vh';
$skey = md5($do.$authcode.$rand);
$epurl = $config['epurl'];
if ($_GET['ban']){
    $id = $_GET['ban'];
    if (!id){
        exit("<script language='javascript'>alert('id参数不能为空!');;window.location.href='sitelist.php';</script>");
    }
    $siteinfo = $db->get_row("SELECT * FROM kaxiao_site WHERE sid='{$id}' LIMIT 1");
    if ($siteinfo['uid'] != $userrow['uid'] and $userrow['uid'] != 1){
        exit("<script language='javascript'>alert('无效操作!');;window.location.href='sitelist.php';</script>");
    }else{
        $get = 'http://'.$epurl.'/api/?c=whm&a='.$do.'&r='.$rand.'&s='.$skey.'&name='.$siteinfo['domain'].'&status=1&json=1';
        $addsite = file_get_contents($get);
        if($addsite=json_decode($addsite,true)) {
            if($addsite['result']==200){
                $db->query("UPDATE kaxiao_site SET active=0 WHERE sid='{$id}'");
                exit("<script language='javascript'>alert('已停封该站点');;window.location.href='sitelist.php';</script>");
            }else{
                exit("<script language='javascript'>alert('未知错误!');;window.location.href='sitelist.php';</script>");
            }
        }
    }
}
if ($_GET['deban']){
    $id = $_GET['deban'];
    if (!id){
        exit("<script language='javascript'>alert('id参数不能为空!');;window.location.href='sitelist.php';</script>");
    }
    $siteinfo = $db->get_row("SELECT * FROM kaxiao_site WHERE sid='{$id}' LIMIT 1");
    if ($siteinfo['uid'] != $userrow['uid'] and $userrow['uid'] != 1){
        exit("<script language='javascript'>alert('无效操作!');;window.location.href='sitelist.php';</script>");
    }else{
        $get = 'http://'.$epurl.'/api/?c=whm&a='.$do.'&r='.$rand.'&s='.$skey.'&name='.$siteinfo['domain'].'&status=0&json=1';
        $addsite = file_get_contents($get);
        if($addsite=json_decode($addsite,true)) {
            if($addsite['result']==200){
                $db->query("UPDATE kaxiao_site SET active=1 WHERE sid='{$id}'");
                exit("<script language='javascript'>alert('已恢复该站点');;window.location.href='sitelist.php';</script>");
            }else{
                exit("<script language='javascript'>alert('未知错误!');;window.location.href='sitelist.php';</script>");
            }
        }
    }
}
if ($_GET['del']){
    $id = $_GET['del'];
    if (!id){
        exit("<script language='javascript'>alert('id参数不能为空!');;window.location.href='sitelist.php';</script>");
    }
    $siteinfo = $db->get_row("SELECT * FROM kaxiao_site WHERE sid='{$id}' LIMIT 1");
	if($userrow['uid'] == 1){
		$do = 'del_vh';
		$skey = md5($do.$authcode.$rand);
		$get = 'http://'.$epurl.'/api/?c=whm&a='.$do.'&r='.$rand.'&s='.$skey.'&name='.$siteinfo['domain'].'&json=1';
		$addsite = file_get_contents($get);
		if($addsite=json_decode($addsite,true)) {
			if($addsite['result']==200){
				$db->query("DELETE FROM kaxiao_site WHERE sid='{$id}'");
				exit("<script language='javascript'>alert('已删除该站点');;window.location.href='sitelist.php';</script>");
			}else{
				exit("<script language='javascript'>alert('未知错误!');;window.location.href='sitelist.php';</script>");
			}
		}
	}
    if ($siteinfo['uid'] != $userrow['uid']){
        exit("<script language='javascript'>alert('无效操作!');;window.location.href='sitelist.php';</script>");
    }else{
        $do = 'del_vh';
        $skey = md5($do.$authcode.$rand);
        $get = 'http://'.$epurl.'/api/?c=whm&a='.$do.'&r='.$rand.'&s='.$skey.'&name='.$siteinfo['domain'].'&json=1';
        $addsite = file_get_contents($get);
        if($addsite=json_decode($addsite,true)) {
            if($addsite['result']==200){
                $db->query("DELETE FROM kaxiao_site WHERE sid='{$id}'");
                exit("<script language='javascript'>alert('已删除该站点');;window.location.href='sitelist.php';</script>");
            }else{
                exit("<script language='javascript'>alert('未知错误!');;window.location.href='sitelist.php';</script>");
            }
        }
    }
}
?>
<main id="main-container">
<div class="content">
<div class="block">
<div class="block-header block-header-default">
<h3 class="block-title">网站管理</h3>
</div>
<div class="block-content">
<div class="table-responsive">
<table class="table table-striped table-vcenter">
<thead>
<tr>
<th>域名</th>
<th>域名管理</th>
<th>状态</th>
<th>所属用户</th>
<th>操作</th>
</tr>
</thead>
<tbody>
<?php if ($sites){foreach($sites as $site){ ?>
 <tr class="demo">
            
            <td><?=$site['domain']?>.<?=$config['domain']?></td>
            <td><a class="btn btn-primary" id="d-button" onclick="domaingl(<?=$site['sid']?>);">域名管理</a></td>
                        <td><?php
                                    if ($site['active'] == 1){
                                        echo "<p style='color:green'>正常</p>";
                                    }else{
                                        echo "<p style='color:red'>已停封</p>";
                                    }
                                    ?>
          </td>
           <td><?=$site['user']?></td>
            <td><?php if ($site['active'] == 1){ ?>
                                        <a class="btn btn-primary" href="?ban=<?=$site['sid']?>">停封</a>
                                    <?php }else{ ?>
                                        <a class="btn btn-primary" href="?deban=<?=$site['sid']?>">恢复</a>
                                    <?php } ?>
                                    <a class="btn btn-danger" href="?del=<?=$site['sid']?>">删除</a>
            </td>
        </tr>
<?php } }else{ ?>
                            <div class="inbox-head" style="text-align:center"><br/><br/>
                                <i class=" icon-hourglass" style="font-size:80px"></i><br/>
                                <h3>目前暂无网站</h3>
                            </div>
                        <?php } ?>            
          </tbody>
</table>
</div>
<div class="btn-group">
<div class="col-sm-12" style="text-align:right;">
                    <ul class="pagination-sm m-t-none m-b pagination ng-isolate-scope ng-valid" boundary-links="true" total-items="totalItems" ng-model="currentPage" previous-text="‹" next-text="›" first-text="«" last-text="»">
<li ng-if="boundaryLinks" ng-class="{disabled: noPrevious()}" class="ng-scope"><a href="?mod=admin-users&p=1" ng-click="selectPage(1)" class="ng-binding">«</a></li>
                        <li ng-if="directionLinks" ng-class="{disabled: noPrevious()}" class="ng-scope"><a href="?p=<?=$prev?>" ng-click="selectPage(page - 1)" class="ng-binding">‹</a></li>
                        
                        <?php for($i=$s;$i<=$pp;$i++){?>
                            <li><a ng-if="boundaryLinks" ng-class="{disabled: noNext()}"  class="ng-scope <?php if($i==$p){echo'active';}?>" href="?p=<?=$i?>" ng-click="selectPage(page.number)" class="ng-binding"><?=$i?></a></li>
                        <?php }?>
<li ng-if="directionLinks" ng-class="{disabled: noNext()}" class="ng-scope"><a href="?p=<?=$next?>" ng-click="selectPage(page + 1)" class="ng-binding">›</a></li>
<li ng-if="boundaryLinks" ng-class="{disabled: noNext()}" class="ng-scope"><a href="?p=<?=$pages?>" ng-click="selectPage(totalPages)" class="ng-binding">»</a></li>
                        
                    </ul>
                </div>
</div>
</div>
</div>
</div>
</main>

<?php require_once('foot.php'); ?>
</div>


<script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
<script>
	function domaingl(id){
		layer.open({
		  type: 2,
		  title: '域名管理',
		  shadeClose: true,
		  shade: false,
		  maxmin: true,
		  area: ['80%', '75%'],
		  content: 'domain.php?sid='+id
		});
	}
</script>
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
 
$title = "账号管理";
require_once('./head.php');
if ($userrow['active'] < 9){exit("<script language='javascript'>alert('无权限!');window.location.href='index.php';</script>");}
$p = is_numeric($_GET['p']) ? $_GET['p'] : '1';
$pp=$p+7;
$pagesize=10;
$start=($p-1)*$pagesize;
$users=$db->rs("SELECT * FROM kaxiao_admin WHERE active=9 or active=0 ORDER BY uid LIMIT $start,$pagesize");
$pages=ceil($db->count('SELECT count(*) FROM kaxiao_admin WHERE active= 9')/$pagesize);
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
if ($_GET['ban']){
    $id = $_GET['ban'];
    if (!$id){
        exit("<script language='javascript'>alert('id参数不能为空!');;window.location.href='userlist.php';</script>");
    }
    if ($id == 1){
        exit("<script language='javascript'>alert('无效操作!');;window.location.href='userlist.php';</script>");
    }else{
        if($db->query("UPDATE kaxiao_admin SET active=0 WHERE uid='{$id}'")){
            exit("<script language='javascript'>alert('已停封该账号!');window.location.href='userlist.php';</script>");
        }else{
            exit("<script language='javascript'>alert('未知错误!');;window.location.href='userlist.php';</script>");
        }
    }
}
if ($_GET['deban']){
    $id = $_GET['deban'];
    if (!$id){
        exit("<script language='javascript'>alert('id参数不能为空!');;window.location.href='userlist.php';</script>");
    }
    if ($id == 1){
        exit("<script language='javascript'>alert('无效操作!');;window.location.href='userlist.php';</script>");
    }else{
        if($db->query("UPDATE kaxiao_admin SET active=9 WHERE uid='{$id}'")){
            exit("<script language='javascript'>alert('已恢复该账号!');window.location.href='userlist.php';</script>");
        }else{
            exit("<script language='javascript'>alert('未知错误!');;window.location.href='userlist.php';</script>");
        }
    }
}
if ($_GET['new']){
    $id = $_GET['new'];
    if (!$id){
        exit("<script language='javascript'>alert('id参数不能为空!');;window.location.href='userlist.php';</script>");
    }
    if ($id == 1){
        exit("<script language='javascript'>alert('无效操作!');;window.location.href='userlist.php';</script>");
    }else{
        if($db->query("UPDATE kaxiao_admin SET pwd='e10adc3949ba59abbe56e057f20f883e' WHERE uid='{$id}'")){
            exit("<script language='javascript'>alert('您的新密码为123456');window.location.href='userlist.php';</script>");
        }else{
            exit("<script language='javascript'>alert('未知错误!');;window.location.href='userlist.php';</script>");
        }
    }
}
if ($_GET['del']){
    $id = $_GET['del'];
    if (!$id){
        exit("<script language='javascript'>alert('id参数不能为空!');;window.location.href='userlist.php';</script>");
    }
    if ($id == 1){
        exit("<script language='javascript'>alert('无效操作!');;window.location.href='userlist.php';</script>");
    }else{
        if($db->query("DELETE FROM kaxiao_admin WHERE uid='{$id}'")){
            exit("<script language='javascript'>alert('已删除该账号!');window.location.href='userlist.php';</script>");
        }else{
            exit("<script language='javascript'>alert('未知错误!');;window.location.href='userlist.php';</script>");
        }
    }
}

if ($_GET['peie']){
    $id = $_GET['peie'];
    $value = $_GET['value'];
    if (!$id){
        exit("<script language='javascript'>alert('id参数不能为空!');window.location.href='userlist.php';</script>");
    }
    if ($id == 1){
        exit("<script language='javascript'>alert('无效操作!');window.location.href='userlist.php';</script>");
    }else{
        if($db->query("UPDATE `kaxiao_admin` SET `limit` = '{$value}' WHERE uid='{$id}'")){
            exit("<script language='javascript'>alert('操作成功!');window.location.href='userlist.php';</script>");
        }else{
            exit("<script language='javascript'>alert('未知错误!');window.location.href='userlist.php';</script>");
        }
    }
}
?>
<main id="main-container">
<div class="content">
<div class="block">
<div class="block-header block-header-default">
<h3 class="block-title">外包列表</h3>
</div>
<div class="block-content">
<div class="table-responsive">
<table class="table table-striped table-vcenter">
<thead>
<tr>
<th>用户名</th>
<th>状态</th>
<th>配额</th>
</tr>
</thead>
<tbody>
<?php if ($users){foreach($users as $user){ ?>
 <tr class="demo">
            <td><?=$user['user']?></td>
            <td><?php
                                    if ($user['active'] == 9){
                                        echo "<p style='color:green'>正常</p>";
                                    }else{
                                        echo "<p style='color:red'>已停封</p>";
                                    }
                                    ?>
              </td>
                        <td><?=$db->count("SELECT count(*) FROM `kaxiao_site` WHERE `uid` = '{$user['uid']}'")?>/<a href="#" onclick="disp_prompt(<?=$user['uid']?>,<?=$user['limit']?>)"><?=$user['limit']?>修改</a>
          </td>
           <td><?php if ($user['active'] == 9){ ?>
                                        <a class="btn btn-primary" href="?ban=<?=$user['uid']?>">停封</a>
                                    <?php }else{ ?>
                                        <a class="btn btn-primary" href="?deban=<?=$user['uid']?>">恢复</a>
                                    <?php } ?>
                                    <a class="btn btn-info" href="?new=<?=$user['uid']?>">重置密码</a>
                                    <a class="btn btn-danger" href="?del=<?=$user['uid']?>">删除</a>
          </td>
        </tr>
<?php } }else{ ?>
                            <div class="inbox-head" style="text-align:center"><br/><br/>
                                <i class=" icon-hourglass" style="font-size:80px"></i><br/>
                                <h3>目前暂无外包</h3>
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


    <script type="text/javascript">
        function disp_prompt(id, value = 0){
            var name = prompt("请输入此用户配额", value);
            if (name != null && name != ""){
                window.location.href = "?peie=" + id + "&value=" + name;
            }
        }
    </script>
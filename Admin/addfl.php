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
 
$title = "源码分类";
require_once('./head.php');
if ($userrow['uid']!=1){exit("<script language='javascript'>alert('无权限!');window.location.href='index.php';</script>");}
$p = is_numeric($_GET['p']) ? $_GET['p'] : '1';
$pp=$p+7;
$pagesize=10;
$start=($p-1)*$pagesize;
$rows=$db->rs("SELECT * FROM kaxiao_fl ORDER BY fid DESC LIMIT $start,$pagesize");
$pages=ceil($db->count('SELECT count(*) FROM kaxiao_fl')/$pagesize);
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
if ($_GET['del']){
	if($db->query("DELETE FROM kaxiao_fl WHERE fid='{$_GET['del']}'")){
		exit("<script language='javascript'>alert('已删除');;window.location.href='addfl.php';</script>");
	}else{
		exit("<script language='javascript'>alert('未知错误');;window.location.href='addfl.php';</script>");
	}
}
if ($_POST['do'] == 'add'){
	$name = $_POST['name'];
	$install = $_POST['install'];
	if($name and $install){
		if($db->query("INSERT INTO `kaxiao_fl` (`name`, `install`) VALUES ('{$name}','{$install}')")){
			exit("<script language='javascript'>alert('添加成功');;window.location.href='addfl.php';</script>");
		}
	}else{
		exit("<script language='javascript'>alert('所有项不能为空');window.location.href='addfl.php';</script>");
	}
}
?>

            <main id="main-container">
                <div class="content content-boxed">
                    <div class="block">
                        <div class="block-header">
                            <h3 class="block-title"><em class="fa fa-bell-o fa-fw"></em>源码设置</h3>
                        </div>
 <div class="panel-body">
                            <table class="js-table-sections table table-hover">
<form class="form-horizontal tasi-form" method="post">
	<input type="hidden" name="do" value="add">
	<div class="form-group">
	<label class="col-sm-2 control-label">源码名称:</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" name="name">
	</div>
	</div>
	<div class="form-group">
	<label class="col-sm-2 control-label">源码安装文件名(不填文件后缀名):</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" name="install">
	</div>
	</div>
	<div align="right">
	 <div class="col-sm-offset-2 col-sm-4"><button type="submit" class="btn btn-primary form-control">添加</button>   </div>
	</div>
</form>
</div><hr>
<div class="col-sm-12">
<section class="panel">
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>源码名称</th>
<th>安装文件</th>
<th>操作</th>
</tr>
</thead>
<tbody>
<?php if ($rows){foreach($rows as $row){ ?>
<tr>
<td><?=$row['name']?></td>
<td><?=$row['install']?></td>
<td>
<a class="btn btn-danger" href="?del=<?=$row['fid']?>">删除</a>
</td>
</tr>
<?php } }else{ ?>
<div class="inbox-head" style="text-align:center">
<i class="icon-hourglass" style="font-size:80px"></i><br>
<h3>目前暂无分类</h3>
</div>
<?php } ?>
</tbody>
</table>

</div>
</section>
<div class="col-sm-12" >
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

</table>
</div>
</div>
</main>


<?php
require_once('foot.php');
?>
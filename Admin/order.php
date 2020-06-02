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
if ($userrow['uid']!=1){exit("<script language='javascript'>alert('无权限!');window.location.href='./index.php';</script>");}
$p = is_numeric($_GET['p']) ? $_GET['p'] : '1';
$pp=$p+7;
$pagesize=10;
$start=($p-1)*$pagesize;

$orders=$db->rs("SELECT * FROM kaxiao_order WHERE 1 ORDER BY id DESC LIMIT $start,$pagesize");
$pages=ceil($db->count('SELECT count(*) FROM kaxiao_order WHERE 1')/$pagesize);

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
?>
<main id="main-container">
<div class="content">
<div class="block">
<div class="block-header block-header-default">
<h3 class="block-title">充值记录</h3>
</div>
<div class="block-content">
<div class="table-responsive">
<table class="table table-striped table-vcenter">
<thead>
<tr>
<th>订单号</th>
<th>用户名</th>
<th>充值配额</th>
<th>充值日期</th>
<th>支付方式</th>
<th>状态</th>
</tr>
</thead>
<tbody>
<?php if ($orders){foreach($orders as $order){ 

$user = $db->get_row("SELECT * FROM kaxiao_admin WHERE uid='".$order['user']."' limit 1;");
if($user['active']==9){
	$user['active']='[外包]';
}else if($user['active']==1){
	$user['active']='[分销]';
}
if($order['type']=='alipay'){
	$order['type']='支付宝';
}else if($order['type']=='qqpay'){
	$order['type']='QQ钱包';
}else if($order['type']=='wxpay'){
	$order['type']='微信支付';
}else{
	$order['type']='错误的支付方式';
}
if($order['state']==1){
	$order['state']='支付成功';
}else{
	$order['state']='支付失败';
}
?>
 <tr class="demo">
            <td><?=$order['order_no']?></td>
            <td><?=$user['user']?><?=$user['active']?></td>
            <td><?=$order['peie']?>个</td>
            <td><?=$order['date']?></td>
            <td><?=$order['type']?></td>
            <td><?=$order['state']?></td>
        </tr>
<?php } }else{ ?>
                            <div class="inbox-head" style="text-align:center"><br/><br/>
                                <i class=" icon-hourglass" style="font-size:80px"></i><br/>
                                <h3>目前暂无充值记录</h3>
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
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

$title = "易支付接口设置";
require_once('./head.php');
if ($userrow['uid']!=1){exit("<script language='javascript'>alert('无权限!');window.location.href='index.php';</script>");}
if ($_POST['do'] == 'do'){
	//判断是否关闭所有支付
	if($_POST['alipay']==0 && $_POST['qqpay']==0 && $_POST['wxpay']==0 ){
		exit("<script language='javascript'>alert('必须有一种支付方式是开启状态！');history.go(-1);</script>");
	}
	if($_POST['alipay']==0 && $_POST['qqpay']==0){
		$_POST['defaultpay']='wxpay';
	}else if($_POST['alipay']==0 && $_POST['wxpay']==0){
		$_POST['defaultpay']='qqpay';
	}else{
		$_POST['defaultpay']='alipay';
	}
	//对默认支付参数进行过滤
	if($_POST['defaultpay']=='alipay'){
		$_POST['defaultpay']='alipay';
	}else if($_POST['defaultpay']=='qqpay'){
		$_POST['defaultpay']='qqpay';
	}else if($_POST['defaultpay']=='wxpay'){
		$_POST['defaultpay']='wxpay';
	}else{
		exit("<script language='javascript'>alert('默认支付错误！');history.go(-1);</script>");
	}
	//判断默认支付是否关闭
	if($_POST[$_POST['defaultpay']]==0){
		exit("<script language='javascript'>alert('默认的支付方式不能是已关闭的支付！');history.go(-1);</script>");
	}
    foreach($_POST as $k => $value){
		$value=htmlspecialchars($value);
        $db->query("UPDATE kaxiao_config SET value='{$value}' WHERE vkey='{$k}'");
    }
    exit("<script language='javascript'>alert('修改成功!');window.location.href='epayset.php';</script>");
}
?>
            <main id="main-container">
                <div class="content content-boxed">
                    <div class="block">
                        <div class="block-header">
                            <h3 class="block-title"><em class="fa fa-bell-o fa-fw"></em>易支付接口设置</h3>
                        </div>
 <div class="panel-body">
                            <table class="js-table-sections table table-hover">
<form class="form-horizontal tasi-form" method="post">
                <input type="hidden" name="do" value="do">
		 <div class="form-horizontal devform">
								
				<div class="form-group">
					<label class="col-sm-2 control-label">默认支付方式:</label>
					<div class="col-sm-9">
                   <select name="defaultpay" class="form-control" style="width: auto;" >
				   <?php if($config['defaultpay']=='alipay'){ ?>
                    <option value="alipay">支付宝</option>
					<option value="qqpay">QQ钱包</option>
					<option value="wxpay">微信支付</option>
				   <?php }else if($config['defaultpay']=='qqpay'){ ?>
					<option value="qqpay">QQ钱包</option>
                    <option value="alipay">支付宝</option>
					<option value="wxpay">微信支付</option>
				   <?php }else{?>
					<option value="wxpay">微信支付</option>
                    <option value="alipay">支付宝</option>
					<option value="qqpay">QQ钱包</option>
				   <?php }?>
                     </select>
					 </div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">支付宝支付:</label>
					<div class="col-sm-9">
                   <select name="alipay" class="form-control" style="width: auto;" >
				   <?php if($config['alipay']==1){ ?>
                    <option value="1">开启</option>
					<option value="0">关闭</option>
				   <?php }else{?>
					<option value="0">关闭</option>
                    <option value="1">开启</option>
				   <?php }?>
                     </select>
					 </div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">QQ钱包支付:</label>
					<div class="col-sm-9">
                   <select name="qqpay" class="form-control" style="width: auto;" >
				   <?php if($config['qqpay']==1){ ?>
                    <option value="1">开启</option>
					<option value="0">关闭</option>
				   <?php }else{?>
					<option value="0">关闭</option>
                    <option value="1">开启</option>
				   <?php }?>
                     </select>
					 </div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">微信支付:</label>
					<div class="col-sm-9">
                   <select name="wxpay" class="form-control" style="width: auto;" >
				   <?php if($config['wxpay']==1){ ?>
                    <option value="1">开启</option>
					<option value="0">关闭</option>
				   <?php }else{?>
					<option value="0">关闭</option>
                    <option value="1">开启</option>
				   <?php }?>
                     </select>
					 </div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">易支付接口地址:</label>
					<div class="col-sm-9">
						<input type="text" name="epayapi" value="<?=$config['epayapi']; ?>"  class="form-control">
						<pre>填写标准：http(s)://接口域名/，必须以/结尾</pre>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">易支付商户ID:</label>
					<div class="col-sm-9">
						<input type="text" name="epayid" value="<?=$config['epayid']; ?>"  class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">易支付商户秘钥:</label>
					<div class="col-sm-9">
						<input type="password" name="epaykey" value="<?=$config['epaykey']; ?>"  class="form-control">
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-4"><button   class="btn btn-primary form-control">确认修改</button><br/>
				 </div>
				 </div>
				 </div>
				</form>
				</table>
	
</div>
    </div>
	</div>
</main>
  

<?php
require_once('foot.php');
?>
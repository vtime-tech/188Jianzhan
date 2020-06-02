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

$title = "在线充值";
require_once('./head.php');
if($userrow['active'] == 10){exit("<script language='javascript'>alert('在线充值功能不对管理员开放！');window.location.href='./index.php';</script>");}
if (!($userrow['active'] == 9 && $config['wbpe']!='0.00' || $userrow['active'] == 1 && $config['fxpe']!='0.00')){exit("<script language='javascript'>alert('充值已关闭！');window.location.href='./index.php';</script>");}
if ($_POST['do'] == 'pay'){
	if(isset($_POST['peie']) && isset($_POST['pay_type'])){
		$peie=htmlspecialchars($_POST['peie']);
		$pay_type=htmlspecialchars($_POST['pay_type']);
		if($peie<=0 || !is_numeric($peie) || strpos($peie,'.')!==false){
			exit("<script language='javascript'>alert('您输入的配额不是有效配额！');history.go(-1);</script>");
		}
		if($pay_type=='alipay'){
			$type='alipay';
		}else if($pay_type=='wxpay'){
			$type='wxpay';
		}else if($pay_type=='qqpay'){
			$type='qqpay';
		}else{
			exit("<script language='javascript'>alert('错误的支付方式！');history.go(-1);</script>");
		}
		if($userrow['active'] == 9){
			$money=sprintf("%.2f",$peie*$config['wbpe']);
		}else if($userrow['active'] == 1){
			$money=sprintf("%.2f",$peie*$config['fxpe']);
		}else{
			exit("<script language='javascript'>alert('您的账号权限不匹配！');history.go(-1);</script>");
		}
		$order_no=date("YmdHis").mt_rand(100,999);
		$db->query("INSERT INTO `kaxiao_order` (`order_no`, `user`, `peie`, `date`, `type`) VALUES ('".$order_no."', '".$userrow['uid']."' , '".$peie."' ,'".date("Y-m-d H:i:s")."' ,'".$type."')");
//支付
require_once("../System/Epay/epay.config.php");
require_once("../System/Epay/epay_submit.class.php");
/**************************请求参数**************************/
        $notify_url = "http://".$_SERVER['HTTP_HOST']."/Admin/epay_notify_url.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = "http://".$_SERVER['HTTP_HOST']."/Admin/epay_return_url.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //商户订单号
        $out_trade_no = $order_no;
        //商户网站订单系统中唯一订单号，必填

        //商品名称
        $name = '配额充值';
		//站点名称
        $sitename = $config['title'];
        //必填

        //订单描述


/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"pid" => trim($alipay_config['partner']),
		"type" => $type,
		"notify_url"	=> $notify_url,
		"return_url"	=> $return_url,
		"out_trade_no"	=> $out_trade_no,
		"name"	=> $name,
		"money"	=> $money,
		"sitename"	=> $sitename
);

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
}else{
	exit('非法访问');
}
}
?>
            <main id="main-container">
                <div class="content content-boxed">
                    <div class="block">
                        <div class="block-header">
                            <h3 class="block-title"><em class="fa fa-credit-card"></em> 在线充值</h3>
                        </div>
 <div class="panel-body">
                            <table class="js-table-sections table table-hover">
<form class="form-horizontal tasi-form" method="post" target="_blank">
                <input type="hidden" name="do" value="pay">
						 <div class="form-horizontal">
		 				<div class="form-group">
					<label class="col-sm-2 control-label">当前信息:</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" value="当前的剩余配额：<?php echo $userrow['limit']; ?>个 | 充值价为<?php if($userrow['active'] == 9){echo $config['wbpe'];}else if(($userrow['active'] == 1)){echo $config['fxpe'];}  ?>元/配额" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">充值个数:</label>
					<div class="col-sm-5">
						<input type="number" class="form-control" name="peie" id="peie" value="1">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">计算价格:</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="money" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">支付方式:</label>
					<div class="col-sm-5">
						<?php if($config['alipay']=='1'){?><input type="radio" <?php if($config['defaultpay']=='alipay')echo'checked="checked"';?> value="alipay" name="pay_type"><img src="./assets/img/alipay.gif" width="135" height="45" alt="支付宝在线支付" title="支付宝在线支付"><?php }?>
						<?php if($config['wxpay']=='1'){?><br/><input type="radio" <?php if($config['defaultpay']=='wxpay')echo'checked="checked"';?> value="wxpay" name="pay_type"><img src="./assets/img/wxpay.gif" width="142" height="45" alt="微信在线支付" title="微信在线支付"><?php }?>
                        <?php if($config['qqpay']=='1'){?><br/><input type="radio" <?php if($config['defaultpay']=='qqpay')echo'checked="checked"';?> value="qqpay" name="pay_type"><img src="./assets/img/qpay.gif" width="142" height="45" alt="QQ钱包在线支付" title="QQ钱包在线支付"> <?php }?>
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-2"><button id="recharge" class="btn btn-primary form-control">充值</button><br/>
				 </div>
				 </div>
				 </div>
				</form>
				</table>
</div>
    </div>
	</div>
</main>
<script type="text/javascript">
	var peie=document.getElementById("peie");
	var money=document.getElementById("money");
	peie.onchange=function()
	{
		if(peie.value<=0 || peie.value%1!=0){
			alert("您输入的配额不是有效配额");
			peie.value='1';
		}
		var total=peie.value * <?php if($userrow['active'] == 9){echo $config['wbpe'];}else if(($userrow['active'] == 1)){echo $config['fxpe'];}  ?>;
		money.value=total.toFixed(2)+" 元";
	}
</script>
<script src="assets/js/core/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
<script type="text/javascript">
	$("form").submit(function(e){
		layer.confirm('是否充值成功？', {
			btn: ['成功','失败'] //按钮
		}, function(){
			location.reload();
		}, function(){
			layer.msg('充值失败！', {icon: 2});
		});
	});
</script>
<?php
require_once('foot.php');
?>
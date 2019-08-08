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

$title = "对接设置";
define('EPAPI_NULL', true);
require_once('./head.php');
if ($userrow['uid']!=1){exit("<script language='javascript'>alert('无权限!');window.location.href='index.php';</script>");}
if ($config['eplock']==1){exit("<script language='javascript'>alert('ep配置锁已打开无法修改ep对接信息，如需修改ep对接信息请到网站设置关闭ep配置锁!');window.location.href='set.php';</script>");}
if ($_POST['do'] == 'do'){
	if($_POST['fwqip']!='' && $_POST['epurl']!='' && $_POST['authcode']!='' && $_POST['epid']!='' && $_POST['domain']!=''){
	$epurl=htmlspecialchars($_POST['epurl']);
	$authcode=htmlspecialchars($_POST['authcode']);
	$rand = rand(1,9999);
	$do = 'info';
	$skey = md5($do.$authcode.$rand);
	$url = 'http://'.$epurl.'/api/?c=whm&a='.$do.'&r='.$rand.'&s='.$skey.'&json=1';
	$result=curl_get($url);
	$api=json_decode($result,true);
	if($api['result'] == 403){
		exit("<script language='javascript'>alert('权限验证失败，请检查ep接口的通信安全码！');history.go(-1);</script>");
	}else if($api['result'] != 200){
		exit("<script language='javascript'>alert('通信失败！');history.go(-1);</script>");
	}
	$eplock='';
	if($config['fwqip']=='' && $config['epurl']=='' && $config['authcode']==''){
		$db->query("UPDATE kaxiao_config SET value='1' WHERE vkey='eplock'");
		$eplock='，ep配置锁已开启，正在跳转到网站设置!';
	}
    foreach($_POST as $k => $value){
		$value=htmlspecialchars($value);
        $db->query("UPDATE kaxiao_config SET value='{$value}' WHERE vkey='{$k}'");
    }
	exit("<script language='javascript'>alert('修改成功".$eplock."');window.location.href='set.php';</script>");
	}else{
		exit("<script language='javascript'>alert('请填写接口信息!');history.go(-1);</script>");
	}
}
?>
            <main id="main-container">
                <div class="content content-boxed">
                    <div class="block">
                        <div class="block-header">
                            <h3 class="block-title"><em class="fa fa-bell-o fa-fw"></em>对接设置</h3>
                        </div>
 <div class="panel-body">
                            <table class="js-table-sections table table-hover">
<form class="form-horizontal tasi-form" method="post">
                <input type="hidden" name="do" value="do">
						 <div class="form-horizontal">
		 				<div class="form-group">
					<label class="col-sm-2 control-label">服务器IP:</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="fwqip" value="<?=$config['fwqip']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">EP面板地址:</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="epurl" value="<?=$config['epurl']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">通信安全码:</label>
					<div class="col-sm-9">
						<input type="password" class="form-control" name="authcode" value="<?=$config['authcode']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">置放空间ID:</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="epid" value="<?=$config['epid']; ?>">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">默认域名:</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="domain" value="<?=$config['domain']; ?>">
						<pre>此处不要随意修改，如需修改请联系客服，随意修改后果自负</pre>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">可选域名:</label>
					<div class="col-sm-9">
						<textarea class="form-control" name="optdomain" rows="6"><?php echo $config['optdomain']; ?></textarea>
						<pre>可选域名并非默认域名，请勿把默认域名填写到可选域名列表里</pre>
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
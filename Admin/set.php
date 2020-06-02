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
 
$title = "系统设置";
require_once('./head.php');
if ($userrow['uid']!=1){exit("<script language='javascript'>alert('无权限!');window.location.href='index.php';</script>");}
if ($_POST['do'] == 'do'){
    foreach($_POST as $k => $value){
		if($k=='fxpe' || $k=='wbpe'){
			if(is_numeric($value)){
				$value=sprintf("%.2f",$value);
			}else{
				$value='0.00';
			}
		}else if($k=='voice'){
			$value=$value;
		}else{
			$value=htmlspecialchars($value);
		}
        $db->query("UPDATE kaxiao_config SET value='{$value}' WHERE vkey='{$k}'");
    }
    exit("<script language='javascript'>alert('修改成功!');history.go(-1);</script>");
}
?>
            <main id="main-container">
                <div class="content content-boxed">
                    <div class="block">
                        <div class="block-header">
                            <h3 class="block-title"><em class="fa fa-bell-o fa-fw"></em>网站设置</h3>
                        </div>
 <div class="panel-body">
                            <table class="js-table-sections table table-hover">
<form class="form-horizontal tasi-form" method="post">
                <input type="hidden" name="do" value="do">
		 <div class="form-horizontal devform">
				
				<div class="form-group">
					<label class="col-sm-2 control-label">网站标题:</label>
					<div class="col-sm-9">
						<input type="text" name="title" value="<?=$config['title']; ?>"  class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">网站副标题:</label>
					<div class="col-sm-9">
						<input type="text" name="titles" value="<?=$config['titles']; ?>"  class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">关键字:</label>
					<div class="col-sm-9">
						<input type="text" name="keywords" value="<?=$config['keywords']; ?>"  class="form-control">
						<pre>本关键字为百度搜索引擎收录重要部分，每个关键字请用,间隔。</pre>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">网站介绍:</label>
					<div class="col-sm-9">
						<input type="text" name="description" value="<?=$config['description']; ?>"  class="form-control">
						<pre>本介绍为百度搜索引擎收录重要部分，请认真填写。</pre>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">网站备案号:</label>
					<div class="col-sm-9">
						<input type="text" name="icp" value="<?=$config['icp']; ?>"  class="form-control">
						<pre>备案查询地址:http://www.miitbeian.gov.cn</pre>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">语音提示:</label>
					<div class="col-sm-9">
						<input type="text" name="voice" value="<?=htmlspecialchars($config['voice']); ?>"  class="form-control">
						<pre>可使用定义变量：{title}网站标题，{titles}网站副标题，{peie}登录用户的配额，{per}用户的权限。</pre>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">首页模板:</label>
					<div class="col-sm-9">
                   <select name="template" class="form-control" style="width: auto;" >
				   <?php if($config['template']==1){ ?>
                    <option value="1">绚丽风格</option>
					<option value="2">彩虹风格</option>
					<option value="0">关闭</option>
				   <?php }if($config['template']==2){ ?>
				    <option value="2">彩虹风格</option>
                    <option value="1">绚丽风格</option>
					<option value="0">关闭</option>
				   <?php }if($config['template']==0){ ?>
				    <option value="0">关闭</option>
				    <option value="2">彩虹风格</option>
                    <option value="1">绚丽风格</option>
				   <?php }?>
                     </select>
					 <pre>根据您的需要选择风格，关闭首页即为登录页面。</pre>
					 </div>
					 </div>
				<div class="form-group">
					<label class="col-sm-2 control-label">ep配置锁:</label>
					<div class="col-sm-9">
                   <select name="eplock" class="form-control" style="width: auto;" >
				   <?php if($config['eplock']==0){ ?>
                    <option value="0">关闭</option>
					<option value="1">开启</option>
				   <?php }else{?>
				   <option value="1">开启</option>
				   <option value="0">关闭</option>
				   <?php }?>
                     </select>
					 <pre>ep配置锁开启后，无法进入对接设置，如需设置对接信息选择关闭即可，第一次保存对接信息后默认开启。</pre>
					 </div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">绚丽彩虹播放器:</label>
					<div class="col-sm-9">
                   <select name="player" class="form-control" style="width: auto;" >
				   <?php if($config['player']==0){ ?>
                    <option value="0">关闭</option>
					<option value="1">开启</option>
				   <?php }else{?>
				   <option value="1">开启</option>
				   <option value="0">关闭</option>
				   <?php }?>
                     </select>
					 </div>
				</div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">绚丽彩虹播放器Key：</label>
					<div class="col-sm-9">
						<input type="text" name="xlchkey" value="<?=$config['xlchkey']; ?>"  class="form-control">
						<pre>获取Key请到http://www.badapple.top</pre>
					</div>
                </div>
				<div class="form-group">
					<label class="col-sm-2 control-label">分销配额单价（元）:</label>
					<div class="col-sm-9">
						<input type="text" name="fxpe" value="<?=$config['fxpe']; ?>"  class="form-control">
						<pre>单价设置0.00为关闭分销的在线充值配额</pre>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">外包配额单价（元）:</label>
					<div class="col-sm-9">
						<input type="text" name="wbpe" value="<?=$config['wbpe']; ?>"  class="form-control">
						<pre>单价设置0.00为关闭外包的在线充值配额</pre>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">客服QQ:</label>
					<div class="col-sm-9">
						<input type="text" name="kfqq" value="<?=$config['kfqq']; ?>"  class="form-control">
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
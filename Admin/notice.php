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

$title = "公告设置";
require_once('./head.php');
if ($userrow['uid']!=1){exit("<script language='javascript'>alert('无权限!');window.location.href='index.php';</script>");}
if ($_POST['do'] == 'do'){
    foreach($_POST as $k => $value){
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
					<label class="col-sm-2 control-label">分销公告:</label>
					<div class="col-sm-9">
						<textarea class="form-control" name="fxgg" rows="6"><?php echo $config['fxgg']; ?></textarea>
					</div>
				</div>

<div class="form-group">
					<label class="col-sm-2 control-label">主站搭建公告:</label>
					<div class="col-sm-9">
						<textarea class="form-control" name="addgg" rows="6"><?php echo $config['addgg']; ?></textarea>
					</div>
				</div>
				
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-4"><button   class="btn btn-primary form-control">确认修改</button><br/>
				 </div>
				</form>
				</table>
	
</div>
    </div>
	</div>
	</div>
	</div>
</main>
<?php
require_once('foot.php');
?>
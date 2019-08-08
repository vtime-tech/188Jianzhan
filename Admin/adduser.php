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

$title = "分销添加";
require_once('./head.php');
if ($userrow['active'] < 9){exit("<script language='javascript'>alert('无权限!');window.location.href='index.php';</script>");}
if ($_POST['do'] == 'add'){
	$user = $_POST['user'];
	$pwd = $_POST['pwd'];
        
	if (!user or !$pwd){
		exit("<script language='javascript'>alert('所有项不能为空!');history.go(-1);</script>");
	}
	if ($db->get_row("SELECT * FROM kaxiao_admin WHERE user='{$user}' LIMIT 1")){
		exit("<script language='javascript'>alert('用户名已存在!');history.go(-1);</script>");
	}
	$pwd = md5($pwd);
	if ($db->query("INSERT INTO `kaxiao_admin` (`user`, `adduser`, `pwd`, `cookie`, `active`) VALUES ('{$user}','{$userrow['user']}','{$pwd}',NULL,1)")){
		exit("<script language='javascript'>alert('添加成功');window.location.href='adduser.php'</script>");
	}else{
		exit("<script language='javascript'>alert('添加失败!');history.go(-1);</script>");
	}
}
?>
  <main id="main-container"> 
   <div class="content content-boxed"> 
    <div class="block"> 
     <div class="block-header"> 
      <h3 class="block-title">分销添加</h3> 
     </div> 
	 <div class="block-content"> 
			 <form class="form-horizontal tasi-form" method="post">
                        <input type="hidden" name="do" value="add">
				<div class="form-group">
					<label class="col-sm-2 control-label">用户名:</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="user" placeholder="请填写用户名!">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">密码:</label>
					<div class="col-sm-9">
				<input type="text" class="form-control" name="pwd" placeholder="请填写密码!">
					</div>
				</div>
                                
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-4"><button type="submit" class="btn btn-primary form-control">添加</button><br/>
				 </div>
				
				
			</form>  
		
	</div>
</div>
    </div>
  </div>
    </main>
<?php
require_once('foot.php');
?>
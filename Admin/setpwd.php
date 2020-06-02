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
 
$title = "修改密码";
require_once('./head.php');
if ($_POST['do'] == 'set'){
	$pwd = $_POST['pwd'];
	$npwd = $_POST['npwd'];
	if (!$pwd or !$npwd){
		exit("<script language='javascript'>alert('所有项不能为空!');history.go(-1);</script>");
	}


	if ($pwd != $npwd){
		exit("<script language='javascript'>alert('两次输入的密码不一致!');history.go(-1);</script>");
	}else{
		$pwd = md5($pwd);
		if ($db->query("UPDATE kaxiao_admin SET pwd='{$pwd}' WHERE uid='{$userrow['uid']}'")){
                        exit("<script language='javascript'>alert('修改成功 请重新登录!');window.location.href='logout.php';</script>");
		}else{
			exit("<script language='javascript'>alert('修改失败!');window.location.href='setpwd.php';</script>");
		}
	}
}
?>
  <main id="main-container"> 
   <div class="content content-boxed"> 
    <div class="block"> 
     <div class="block-header"> 
      <h3 class="block-title">密码修改</h3> 
     </div> 
     <div class="block-content"> 
	<form class="form-horizontal tasi-form" method="post">
      <input type="hidden" name="do" value="set" />
      <div class="form-group"> 
       <label class="col-sm-2 control-label">新密码:</label> 
       <div class="col-sm-10"> 
        <input type="text" class="form-control" name="pwd" placeholder="请输入新密码!" /> 
       </div> 
      </div>
      <br />
      <div class="form-group"> 
       <label class="col-sm-2 control-label">确认密码:</label> 
       <div class="col-sm-10"> 
        <input type="text" class="form-control" name="npwd" placeholder="请再输入密码!" /> 
       </div> 
      </div>
      <br />
      <div class="form-group"> 
       <div class="col-sm-offset-2 col-sm-4">
        <button type="submit" class="btn btn-primary">确认修改</button> 
       </div> 
      </div>
      <table class="js-table-sections table table-hover"> 
       <form class="form-horizontal tasi-form" method="post"></form> 
       <input type="hidden" name="do" value="set" />       
      </table> 
	  </form>
     </div> 
    </div> 
   </div> 
  </main>
<?php
require_once('foot.php');
?>
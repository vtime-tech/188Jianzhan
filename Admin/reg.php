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
 
include("../System/Common.php");
if(isset($_POST['user']))
{

	if(!isset($_POST['pwd']) )
	{
		echo '<script>alert("请填写密码")</script>';
	}else{
			
		$user=$_POST['user'];
			if(exists($user))
			{

				echo '<script>alert("用户名已经有了！请你重新填写")</script>';
			}else{
						if(!isset($_POST['by']))
						{
								$by='admin';
						}else{
								$by=$_POST['by'];
						}

						$passwd=md5($_POST['pwd']);
						$conn = new mysqli($Mysql['host'], $Mysql['user'], $Mysql['pwd'], $Mysql['name']);
						if ($conn->connect_error) {
					    die("连接失败: " . $conn->connect_error);
						}
						$stmt = $conn->prepare("insert into kaxiao_admin (adduser,user,pwd,active,`limit`) values (?,?,?,1,0)");
						$stmt->bind_param("sss",$by,$user,$passwd);
						$stmt->execute();
						$stmt->close();
						$conn->close();

				echo '<script>alert("注册成功！")</script>';
				echo '<script>window.location.href="./login.php"</script>';
			}
	}
}



function exists($user)
{
	 global $Mysql;

	$conn = new mysqli($Mysql['host'], $Mysql['user'], $Mysql['pwd'], $Mysql['name']);
	if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
	}
	$stmt = $conn->prepare("select uid from kaxiao_admin where user=?");
	$stmt->bind_param("s",$user );
	$stmt->execute();
	$result=$stmt->get_result();

	$stmt->close();
	$conn->close();
	if($result->num_rows!=0){
		return true;
	}
	return false;
}
?>
<!DOCTYPE html>
<html class="no-focus" lang="en">
 <head> 
  <meta charset="utf-8" /> 
  <title>注册 | <?=$config['title']?></title> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> 
  <link rel="shortcut icon" href="./favicon.png" /> 
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700" /> 
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" /> 
  <link rel="stylesheet" id="css-main" href="assets/css/oneui.css" /> 
 </head> 
 <body> 
  <div class="content overflow-hidden"> 
   <div class="row"> 
    <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4"> 
     <div class="block block-themed animated fadeIn"> 
      <div class="block-header bg-primary"> 
       <ul class="block-options"> 
       </ul> 
       <h3 class="block-title">注册</h3> 
      </div> 
      <div class="block-content block-content-full block-content-narrow"> 
       <h1 class="h2 font-w600 push-30-t push-5"><?=$config['title']?></h1> 
       <p>欢迎使用, 注册.</p> 
       <form class="js-validation-login form-horizontal push-30-t push-50" method="post"> 
        <div class="form-group"> 
         <div class="col-xs-12"> 
          <div class="form-material form-material-primary floating"> 
           <input class="form-control" type="text" id="login-username" name="user" /> 
           <label for="login-username">用户名</label> 
          </div> 
         </div> 
        </div> 
        <div class="form-group"> 
         <div class="col-xs-12"> 
          <div class="form-material form-material-primary floating"> 
           <input class="form-control" type="password" id="login-password" name="pwd" /> 
           <label for="login-password">密码</label> 
          </div> 
         </div> 
        </div> 
        <div class="form-group"> 
         <div class="col-xs-12"> 
          <div class="form-material form-material-primary floating"> 
           <input class="form-control" type="password" id="login-password" name="pwd2" /> 
           <label for="login-password">再次密码</label> 
          </div> 
         </div> 
        </div> 
         <div class="form-group"> 
         <div class="col-xs-12"> 
          <div class="form-material form-material-primary floating"> 
           <input class="form-control" type="text" id="login-username" name="by" /> 
           <label for="login-username">推荐人(不填写上级为主管理员)</label> 
          </div> 
         </div> 
        </div> 
        <div class="form-group"> 
         <div class="col-xs-12"> 
          <label class="css-input switch switch-sm switch-primary"> <input type="checkbox" id="login-remember-me" name="login-remember-me" /><span></span> 记住我·? </label> 
         </div> 
        </div> 
        <div class="form-group"> 
         <div class="col-xs-12 col-sm-6 col-md-4"> 
          <input type="hidden" name="do" value="login" /> 
          <button class="btn btn-block btn-primary" type="submit"><i class="si si-login pull-right"></i> 注册</button> 
         </div> 
        </div> 
       </form> 
      </div> 
     </div> 
    </div> 
   </div> 
  </div> 
  <div class="push-10-t text-center animated fadeInUp"> 
   <small class="text-muted font-w600"><span class="js-year-copy"></span> &copy; <?=$config['title']?></small> 
  </div> 
  <script src="assets/js/core/jquery.min.js"></script> 
  <script src="assets/js/core/bootstrap.min.js"></script> 
  <script src="assets/js/core/jquery.slimscroll.min.js"></script> 
  <script src="assets/js/core/jquery.scrollLock.min.js"></script> 
  <script src="assets/js/core/jquery.appear.min.js"></script> 
  <script src="assets/js/core/jquery.countTo.min.js"></script> 
  <script src="assets/js/core/jquery.placeholder.min.js"></script> 
  <script src="assets/js/core/js.cookie.min.js"></script> 
  <script src="assets/js/plugins/jquery-validation/jquery.validate.min.js"></script> 
  <script src="assets/js/app.js"></script>
 </body>
</html>
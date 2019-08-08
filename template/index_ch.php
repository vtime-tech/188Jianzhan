<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="">
<title><?=$config['title']?> - <?=$config['titles']?></title>
<meta name="keywords" content="<?=$config['keywords']; ?>"/>
<meta name="description" content="<?=$config['description']; ?>"/>
<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
<link href="assets/css/main.css" rel="stylesheet">
<link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<link href="//cdn.bootcss.com/animate.css/3.5.2/animate.min.css" rel="stylesheet">
<script src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>

<!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body data-spy="scroll" data-offset="0" data-target="#navbar-main">
<div id="navbar-main"> 
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a class="navbar-brand" href="/"><?=$config['title']?></a> </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li> <a href="Admin/login.php" class="smoothScroll">登录</a></li>
          <li> <a href="Admin/reg.php" class="smoothScroll"> 注册</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div id="headerwrap" name="home">
    <p><h1><?=$config['title']?></h1></p>
    <p>几分钟内搭建您的个人站点</p>
    <p>高安全性，无需担心数据泄露</p>
	<p>支持用户外包，轻松赚取您的第一桶金</p>
    <a href="Admin/login.php" class="smoothScroll btn btn-lg">登录</a> </header>
    <a href="Admin/reg.php" class="smoothScroll btn btn-lg">注册</a> </header>
</div>

<div id="about">
  <div class="container">
    <div class="row white">
      <h2 class="centered"><?=$config['title']?>简介</h2>
      <hr>
      <div class="col-lg-8 col-lg-offset-2">
        <p class="large centered"><?=$config['title']?>是一款简便快捷的建站系统，您无需建站技术只需几个步骤即可搭建属于您的站点，轻轻一点即可建站，免去您技术上的烦恼。是您值得信赖的云建站专家！</p>
      </div>
    </div>
  </div>
</div>

<div id="team">
  <div class="container">
    <div class="row white">
      <h2 class="centered">核心优势</h2>
      <hr>
      <div class="col-md-3 centered"> <img class="img" src="assets/images/index/team01.jpg" height="154px" width="250px" alt="">
        <h4><strong>一站式管理</strong></h4>
        <p>使用<?=$config['title']?>，无需购买主机无需技术，注册登陆后充值搭建即可使用，您可以随时在电脑/手机/平板登陆本网站进行功能设置.</p>
      </div>
      <div class="col-md-3 centered"> <img class="img" src="assets/images/index/team02.jpg" height="154px" width="250px" alt="">
        <h4><b>数据安全</b></h4>
        <p>采用阿里云RDS云数据库，数据加密储存，抵抗各种注入破解，保证每一位用户的账号数据安全！</p>
      </div>
      <div class="col-md-3 centered"> <img class="img" src="assets/images/index/team03.jpg" height="154px" width="250px" alt="">
        <h4><b>分布式服务器</b></h4>
        <p>分布式服务器全天24H处理业务，客户站点所在服务器为托管于宿迁优质高防机房实体服务器，保障业务正常运营.</p>
      </div>
      <div class="col-md-3 centered"> <img class="img" src="assets/images/index/team04.jpg" height="154px" width="250px" alt="">
        <h4><b>专员服务</b></h4>
        <p>客服24小时随叫随到 为您解答任何问题 让您的体验更加愉快.</p>
      </div>
    </div>
  </div>
</div>

<div id="contact">
  <div class="container">
    <div class="row centered">
      <h2 class="centered">About</h2>
      <hr>
	  <div class="col-xs-12 col-md-4">
<h4>友情链接</h4>
<p><a href="http://www.baidu.com/" target="_blank">百度</a></p>
<p><a href="http://www.sina.cn/" target="_blank">新浪</a></p>
<p><a href="http://www.360.cn/" target="_blank">360</a></p>
</div>
<div class="col-xs-12 col-md-4">
<h4>关于我们</h4>
<p><?=$config['title']?>是一款简便快捷的建站系统</p>
</div>
<div class="col-xs-12 col-md-4">
<h4>联系我们</h4>
<p><strong>QQ:</strong><a target="_blank"href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=$config['kfqq']?>&amp;site=qq&amp;menu=yes"><?=$config['kfqq']?></a></p>
</div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
$('#WIDout_trade_no').val(new Date().getTime()+Math.floor(Math.random() * 1000));

});
</script>
<!--
<div id="team">
  <div class="container">
    <div class="row centered">
      <h2 class="centered"></h2>
      <hr>
      <div class="col-sm-2 centered" style="margin-bottom:30px;"> <img class="img" src="" width="150px" alt=""><h4></h4></div>
    </div>
  </div>
</div>
-->
<div id="footerwrap">
  <div class="container">
    <div class="row">
      <div class="col-md-12 centered"> <span class="copyright">Copyright &copy; 2018 </span> </div>
    </div>
  </div>
</div>
<?php
	if ($config['player'] == '1' ){
		echo '<script>XlchKey="'.$config['xlchkey'].'";</script>
<link href="//lib.baomitu.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script src="//lib.baomitu.com/jquery/2.2.4/jquery.min.js"></script>
<script src="//lib.baomitu.com/jquery-mousewheel/3.1.9/jquery.mousewheel.min.js"></script>
<script src="//static.badapple.top/BadApplePlayer/js/scrollbar.js"></script>
<script src="//static.badapple.top/BadApplePlayer/Player.js"></script>';
	}elseif ($config['player'] == '0' ) {
    echo '';
  }
?>
<script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript"  src="https://idm-su.baidu.com/su.js"></script>
</body>
</html>
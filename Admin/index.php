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

$title = "控制台";
require_once('./head.php');
$sitecount = $db->count("SELECT count(*) FROM `kaxiao_site` WHERE `uid` = '{$userrow['uid']}'");
?>
            <main id="main-container">
                <div class="content bg-image overflow-hidden" style="background-image: url('assets/img/photos/photo3@2x.jpg');">
                    <div class="push-50-t push-15">
                        <h1 class="h2 text-white animated zoomIn">控制台</h1>
                        <h2 class="h5 text-white-op animated zoomIn">欢迎回来,<?php
	if ($userrow['active'] == 10){
		echo '超级管理员';
	}elseif ($userrow['active'] ==9 ) {
    echo '外包商';
  }else{
    echo "分销商";
  }
?></h2>
                    </div>
                </div>
                <div class="content content-boxed">
                    <div class="block">
                        <div class="block-header">
                            <h3 class="block-title"><em class="fa fa-bell-o fa-fw"></em>最新公告</h3>
                        </div>

                            <table class="js-table-sections table table-hover">
                            <?php echo $config['fxgg']; ?> 
                            </table>
                            </div>

                    <div class="block">
                        <div class="block-header">
                            <h3 class="block-title"><em class="fa fa-bell-o fa-fw"></em>帐号信息</h3>
                        </div>

                            <table class="js-table-sections table table-hover">
                          <div class="panel-body">
 <div class="list-group">
<li class="list-group-item"><b>站点数量：</b><?=$db->count('SELECT count(*) FROM kaxiao_site')?>个</li>
<li class="list-group-item"><b>账号权限：</b><?php
	if ($userrow['active'] == 10){
		echo '超级管理员';
	}elseif ($userrow['active'] ==9 ) {
    echo '外包商';
  }else{
    echo "分销商";
  }
?></li>
<li class="list-group-item"><b>账号配额：</b><?=$userrow['limit']?>个</li>
<li class="list-group-item"><b>当前时间：</b><?=date("Y-m-d H:i:s")?></li>
<li class="list-group-item"><b>功能导航：</b>
<a href="sitelist.php" class="btn btn-xs btn-danger">主站列表</a> 
  <a href="addsite.php" class="btn btn-xs btn-success">搭建主站</a> 
    <a href="setpwd.php" class="btn btn-xs btn-warning">修改密码</a>
  </li>
  </div>
  </div>
</table>
 </div>
 </main>
 <script>
var audio=document.createElement('audio');  
var play = function (s) {
    var URL = 'https://fanyi.baidu.com/gettts?lan=zh&text=' + encodeURIComponent(s) + '&spd=5&source=web'

    if(!audio){
        audio.controls = false  
        audio.src = URL 
        document.body.appendChild(audio)  
    }
    audio.src = URL  
    audio.play();
}
play('<?php  
if(version_compare(PHP_VERSION,'5.4', '<')){  
    echo '您的PHP版本不符合建站系统要求，请管理员检查环境！';  
	}elseif (version_compare(PHP_VERSION,'5.7', '>')) {
    echo '您的PHP版本不符合建站系统要求，请管理员检查环境！';
}else{  
$voice=$config['voice'];
$voice=str_replace('{title}',$config['title'],$voice);//网站标题
$voice=str_replace('{titles}',$config['titles'],$voice);//网站副标题
$voice=str_replace('{peie}',$userrow['limit'],$voice);//登录用户的配额
if($userrow['active']==10){//用户的权限
	$voice=str_replace('{per}','超级管理员',$voice);
}else if($userrow['active']==9){
	$voice=str_replace('{per}','外包用户',$voice);
}else if($userrow['active']==1){
	$voice=str_replace('{per}','分销用户',$voice);
}else{
	$voice=str_replace('{per}','用户',$voice);
}
    echo $voice;  
}
?>
');
</script>
<?php
require_once('./foot.php');
?>
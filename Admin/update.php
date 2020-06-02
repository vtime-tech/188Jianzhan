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
 
$title='在线更新';
include './head.php';
?>
<?php
$version=curl_get("http://update.188jianzhan.cn/ver.txt");
if($version>VERSION){
	$info='发现新版本，点击更新';
}else{
	$info='已经是最新版本，无需更新';
}
?>
<main id="main-container">
                <div class="content content-boxed">
                    <div class="block">
                        <div class="block-header">
                            <h3 class="block-title"><em class="fa fa-bell-o fa-fw"></em>在线更新-最新版本:<?php echo $version?>   当前版本:<?php echo VERSION?></h3>
                        </div>

                            <table class="js-table-sections table table-hover">
 <div class="panel-body">
        <div class="panel-heading"><h3 class="panel-title"></h3></div>
    <?php if(!isset($_GET['install'])){ ?>
<iframe src="http://update.188jianzhan.cn/readme.php" style="width:100%;height:400px;"></iframe>
<div class="panel-body">
<p align="center"><a class="btn btn-block btn-success" href="<?=$_SERVER['PHP_SELF']?>?install"/><?php echo $info?></a></p>
</div>
</div>
</table>
</div>
</div>
</main>
    <?php }else{
		if(ini_get('allow_url_fopen') && class_exists('ZipArchive')){
			if($version<=VERSION){
				exit("<script language='javascript'>alert('已经最新，无需更新！');window.location.href='./update.php';</script>");
			}
			$result=curl_get("http://update.78vu.cn/update.php?ver=".VERSION);
			$result=json_decode($result,true);
			if($result['code']!=1){
				echo '<p>更新报错内容</p>';
				echo '<p>错误代码：'.$result['code'].'</p>';
				echo '<p>错误信息：'.$result['msg'].'</p>';
				echo '<p>请联系程序的技术解决此问题！</p>';
				exit;
			}
			if(copy($result['file'],'Archive.zip')){
				echo '<p>下载更新包成功</p>';
			}else{
				echo '<p>下载更新包失败</p>';
				exit;
			}
			$zip = new ZipArchive;
			if($zip->open('./Archive.zip') && $zip->extractTo('../')){
				echo '<p>解压成功</p>';
				$zip->close();
			}else{
				echo '<p>解压失败</p>';
				exit;
			}
			if(!empty($result['sql'])){
				$sql=$result['sql'];
				$t=0;$e=0;$error='';
				for($i=0;$i<count($sql);$i++) {
					if (trim($sql[$i])=='')continue;
					if($db->query($sql[$i])) {
						++$t;
					}else {
						++$e;
						$error.=$db->error().'<br/>';
					}
				}
				echo '<p>数据库更新成功。SQL成功'.$t.'句/失败'.$e.'句</p>';
			}
			if(is_file(dirname(__FILE__).'/Archive.zip'))unlink(dirname(__FILE__).'/Archive.zip');
			echo '<p>更新成功[YES]！</p>';
			echo '<p><a href="./">点击这里返回首页</a><hr/><pre>'.file_get_contents('../readme.txt').'</pre></p>';
		}else{ ?>
    <p>    
      由于功能问题，该脚本无法在您的空间运行。<br/>
      错误：无法打开远程文件或<b>ZipArchive</b>类不存在！
    </p>
  </div>
  </div>
</table>

 </div>
 </div>
   </main>
  </div>

	  <?php }} ?>

 <?php
include 'foot.php';
?>
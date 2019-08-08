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
 
$title = "关于系统";
require_once('./head.php');
if ($userrow['uid']!=1){exit("<script language='javascript'>alert('无权限!');window.location.href='index.php';</script>");}
?>
            <main id="main-container">
			                <div class="content content-boxed">
			                    <div class="block">
                        <div class="block-header">
                            <h3 class="block-title"><em class="fa fa-bell-o fa-fw"></em>系统信息</h3>
                        </div>

                            <table class="js-table-sections table table-hover">
                          <div class="panel-body">
 <div class="list-group">
<li class="list-group-item"><b>程序名称：</b>鑫迪建站系统V<?php echo VERSION;?> <span class="label label-success">正版</span></li>
<li class="list-group-item"><b>授权情况：</b>IP：<span class="label label-success">已授权</span> 域名：<span class="label label-success">已授权</span></li>
<li class="list-group-item"><b>PHP版本：</b><?php  
if(version_compare(PHP_VERSION,'5.4', '<') || version_compare(PHP_VERSION,'5.7', '>')){  
    echo '<span class="label label-danger">不支持</span>';  
}else{  
    echo '<span class="label label-success">支持</span>';  
}
?>
  </li>
<li class="list-group-item"><b>curl_exec()：</b><?php echo checkfunc('curl_exec',true); ?></li>
<li class="list-group-item"><b>file_get_contents()：</b><?php echo checkfunc('file_get_contents',true); ?></li>
<li class="list-group-item"><b>官方售后群：</b>164483883 	</li>
  </div>
  </div>
</table>
 </div>
 </div>
 </main>
 <?php
require_once('./foot.php');
?>
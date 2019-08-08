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
 
$title = "网站搭建";
require_once('./head.php');
if ($_POST['do'] == 'add'){
    $sitecount = $db->count("SELECT count(*) FROM `kaxiao_site` WHERE `uid` = '{$userrow['uid']}'");

  if ($userrow['uid'] != 1 && $userrow['limit'] <= 0){
        exit("<script language='javascript'>alert('当前配额不足!');history.go(-1);</script>");
    }


    
    $domain = $_POST['domain'];
    $optd = $_POST['optd'];
	$lb = $_POST['ymlb'];
    if ($optd)
        $optdomain = $domain . '.' . $optd;

    if (!$domain){
        exit("<script language='javascript'>alert('域名前缀不能为空!');history.go(-1);</script>");
    }
    if ($optd && $db->get_row("SELECT * FROM `kaxiao_site` WHERE `optdomain`='{$optdomain}' LIMIT 1")){
        exit("<script language='javascript'>alert('可选域名被占用,请换一个!');history.go(-1);</script>");
    }

    if ($db->get_row("SELECT * FROM kaxiao_site WHERE domain='{$domain}' LIMIT 1")){
        exit("<script language='javascript'>alert('域名前缀重复,请换一个!');history.go(-1);</script>");
    }

    $password = substr(md5(uniqid().rand(1,10000)),16);
    $authcode = $config['authcode'];
    $rand = rand(1,9999);
    $do = 'add_vh';
    $skey = md5($do.$authcode.$rand);
    $epurl = $config['epurl'];
    $epid = $config['epid'];
    $ip = $config['fwqip'];
    $get = 'http://'.$epurl.'/api/?c=whm&a='.$do.'&r='.$rand.'&s='.$skey.'&name='.$domain.'&passwd='.$password.'&init=1&json=1&product_id='.$epid.'&month=12';
    $addsite = file_get_contents($get);
    if($addsite=json_decode($addsite,true)) {
        function js($val = null, $href = null){
            $href = $href ? 'window.location.href="' . $href . '";' : 'history.go(-1);';
            exit('<script language="javascript">alert("'.$val.'");' . $href . '</script>');
        }

        if($addsite['result'] != 200) {
            js('创建出错, 请检查系统设置是否正确! 或者换个前缀试试~');
        }

        if ($optdomain){
            // 绑定域名

            // 登录
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://'.$epurl.'/vhost/index.php?c=session&a=login');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('username' => $domain, 'passwd' => $password)));
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            $p = curl_exec($ch);
            curl_close($ch);
            preg_match('/PHPSESSID=(.{26})/i', $p, $matches);
            $cookie = $matches[1];

            // 首页
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://'.$epurl.'/vhost/index.php');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie: PHPSESSID=' . $cookie));
            $p2 = curl_exec($ch);
            curl_close($ch);

            // 绑定
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://'.$epurl.'/vhost/index.php?c=domain&a=add&domain=' . urlencode($optdomain) . '&subdir=%2Fwwwroot&replace=1');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie: PHPSESSID=' . $cookie));
            $p3 = curl_exec($ch);
            curl_close($ch);

            if ($p3 != '成功'){
                file_get_contents('http://'.$epurl.'/api/?c=whm&a=del_vh&r='.$rand.'&s='.md5('del_vh'.$authcode.$rand).'&name='.$domain);
                js('备用域名绑定失败, 原因:' . $p3 . '');
            }

        }
            // 初始化
            $backdata = file_get_contents('http://'.$ip.'/'.$lb.'.php?user='.$domain.'&domain='.$config['domain'].'&password='.$password.'&apiu='.urlencode('http://'.$_SERVER['HTTP_HOST']));

            if ( ! $backdata){
                file_get_contents('http://'.$epurl.'/api/?c=whm&a=del_vh&r='.$rand.'&s='.md5('del_vh'.$authcode.$rand).'&name='.$domain);
                js('站点初始化系统未响应');
            }

            $site = $db->query("INSERT INTO `kaxiao_site` (`uid`, `domain`, `optdomain`, `active`, `user`,`passwd`) VALUES ('{$userrow['uid']}', '{$domain}' , '{$optdomain}' ,1,'{$userrow['user']}','{$password}')");
            if ( ! $site){
                file_get_contents('http://'.$epurl.'/api/?c=whm&a=del_vh&r='.$rand.'&s='.md5('del_vh'.$authcode.$rand).'&name='.$domain);
                js('站点信息载入数据库出错');
            }
  if ($userrow['uid'] != 1){
        $userrow['limit']-- ;
        $db->query("UPDATE kaxiao_admin SET `limit` = '{$userrow['limit']}' WHERE uid = '{$userrow['uid']}'");
  }
            js('搭建成功, 域名:' . $domain . '.' . $config['domain'] . ($optdomain ? ', 备用域名:' . $optdomain : null), 'addsite.php');


    }
}
?>
            <main id="main-container">
                <div class="content content-boxed">
                    <div class="block">
                        <div class="block-header">
                            <h3 class="block-title"><em class="fa fa-bell-o fa-fw"></em>网站搭建</h3>
                        </div>

          <table class="js-table-sections table table-hover">
		<div class="panel-body">
			 <form class="form-horizontal tasi-form" method="post">
                        <input type="hidden" name="do" value="add">
				<div class="form-group">
					<label class="col-sm-2 control-label">域名前缀:</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="domain" placeholder="请填写域名前缀,默认提供的二级域名后缀为<?=$config['domain']?>">
<p class="help-block">域名前缀不能填写中文及特殊字符</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">可选域名后缀</label>
					<div class="col-sm-9">
						<select class="form-control" id="optd" name="optd">
                                    <option value="">不使用</option>
                                    <?php
                                    $domain_list = explode("\n", str_replace(array(" ", ",", "|", "\r\n", "\r"), "\n", $config['optdomain']));
                                    foreach ($domain_list as $row){
                                        if ($row)
                                            echo '<option value="'.$row.'">'.$row.'</option>';
                                    }
                                    ?>
                                </select>
                                <p class="help-block">可选域名单独绑定在站点上</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">源码类别:</label>
					<div class="col-sm-9">
						<select class="form-control m-bot15" name="ymlb">
						<?php
						$rows = $db->rs("SELECT * FROM kaxiao_fl");
						foreach($rows as $row){
						?>
						<option value="<?=$row['install']?>"><?=$row['name']?></option>
						<?php } ?>
						</select>  
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-4"><button type="submit" class="btn btn-info form-control">开始搭建</button><br/>
				 </div>
				
				</div>
			
			</form>  
			</div>
		</table>
	</div>
                    <div class="block">
                        <div class="block-header">
                            <h3 class="block-title"><em class="fa fa-bell-o fa-fw"></em>最新公告</h3>
                        </div>

                            <table class="js-table-sections table table-hover">
 
<?php echo $config['addgg']; ?>

                            </table>

 </div>
 </div>
  </div>
</main>
<?php
require_once('foot.php');
?>
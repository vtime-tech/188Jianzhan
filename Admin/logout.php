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

require_once('../System/Common.php');
$newsid=md5(uniqid().rand(1,1000));
$db->query("update kaxiao_admin set cookie='$newsid' where uid='{$userrow['uid']}'");
setcookie("kaxiao_sid", "", -1, '/');
header("Location:login.php");
exit("<script language='javascript'>alert('您已安全退出！');window.location.href='login.php';</script>");
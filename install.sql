# 188建站系统数据库语句文件
DROP TABLE IF EXISTS `kaxiao_admin`;
CREATE TABLE `kaxiao_admin` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `adduser` varchar(16) DEFAULT NULL,
  `user` varchar(255) NOT NULL,
  `pwd` varchar(40) NOT NULL,
  `cookie` varchar(50) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `limit` int(11) DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `kaxiao_admin` DISABLE KEYS */;
INSERT INTO `kaxiao_admin` VALUES (1,'','admin','e10adc3949ba59abbe56e057f20f883e','',10,1);
/*!40000 ALTER TABLE `kaxiao_admin` ENABLE KEYS */;

DROP TABLE IF EXISTS `kaxiao_config`;
CREATE TABLE `kaxiao_config` (
  `vkey` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`vkey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `kaxiao_config` DISABLE KEYS */;
INSERT INTO `kaxiao_config` VALUES ('addgg','<div class=\"panel-body\">\r\n<font color=\"#000000\"> <div class=\"list-group-item reed\">\r\n<span class=\"label label-default\">支持搭建：</span>\r\n<span class=\"label label-primary\">代刷网</span>  <span class=\"label label-danger\">发卡网</span> <span class=\"label label-warning\">博客网</span> <span class=\"label label-success\">要饭网</span> <span class=\"label label-primary\">表白墙</span>  <span class=\"label label-danger\">音乐网</span> <span class=\"label label-warning\">同学录</span> <span class=\"label label-success\">易支付</span> \r\n</font></div>\r\n<li class=\"list-group-item\">交流群：693401044</li>\r\n<li class=\"list-group-item\">正版授权代刷网需要60元授权后才能使用，授权联系QQ9571564</li>\r\n</div>'),('alipay','1'),('authcode',''),('defaultpay','alipay'),('description','188建站系统-新一代智能自助建站系统,自动化建设神器。易学易懂,功能强大,拥有多种精美网站款式。无需建站技术，一键自动搭建。价格低，性比价高，节省资金！'),('domain',''),('epayapi',''),('epayid',''),('epaykey',''),('epid',''),('eplock','0'),('epurl',''),('fwqip',''),('fxgg','<div class=\"panel-body\">\r\n<li class=\"list-group-item\">系统版本:188建站系统V2.10</li>\r\n<font color=\"#000000\"> <div class=\"list-group-item reed\">\r\n<span class=\"label label-default\">支持搭建：</span>\r\n<span class=\"label label-primary\">代刷网</span>  <span class=\"label label-danger\">发卡网</span> <span class=\"label label-warning\">博客网</span> <span class=\"label label-success\">要饭网</span> <span class=\"label label-primary\">表白墙</span>  <span class=\"label label-danger\">音乐网</span> <span class=\"label label-warning\">同学录</span> <span class=\"label label-success\">易支付</span> \r\n</font></div>\r\n<li class=\"list-group-item\">交流群：693401044</li>\r\n<li class=\"list-group-item\">正版授权代刷网需要60元授权后才能使用，授权联系QQ9571564</li>\r\n<li class=\"list-group-item\">外包禁止随意划拨配额，出售多少钱就划拨多少个配额</li>\r\n<li class=\"list-group-item\">如需绑定自己的域名请先把域名解析到iP：127.0.0.1 然后再去主站列表里面绑定域名</li>\r\n</div>'),('fxpe','0.00'),('icp','京ICP证88888号'),('keywords','188建站系统,一键建站系统,自助建站,智能建站,建站系统,一键搭建,188建站系统,玩客建站,辽宁微时光科技有限公司'),('kfqq','296505795'),('optdomain',''),('player','0'),('qqpay','1'),('template','1'),('title','188建站系统'),('titles','您值得信赖的云建站专家'),('voice','尊敬的{per}，您好，欢迎使用\"{title}\"，您目前还有\"{peie}\"个配额，可以在站点管理中搭建网站。'),('wbpe','0.00'),('wxpay','1'),('xlchkey','pK0xsYXLVy');
/*!40000 ALTER TABLE `kaxiao_config` ENABLE KEYS */;

DROP TABLE IF EXISTS `kaxiao_fl`;
CREATE TABLE `kaxiao_fl` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `install` varchar(255) NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `kaxiao_fl` DISABLE KEYS */;
INSERT INTO `kaxiao_fl` VALUES (1,'表白墙','bb'),(2,'代挂网','djdg'),(3,'发卡网','ayfk'),(4,'代刷4.7','dsmsq'),(5,'易支付','epay'),(6,'影视网1','movie'),(7,'影视网2','movie2'),(8,'音乐网','music'),(9,'要饭网','yf'),(10,'似水年华同学录','ssnhtxl'),(11,'绚丽彩虹同学录','xlchtxl'),(12,'144G网页制作','144gweb');
/*!40000 ALTER TABLE `kaxiao_fl` ENABLE KEYS */;

DROP TABLE IF EXISTS `kaxiao_order`;
CREATE TABLE `kaxiao_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` text,
  `user` int(11) DEFAULT NULL,
  `peie` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `state` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `kaxiao_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `kaxiao_order` ENABLE KEYS */;

DROP TABLE IF EXISTS `kaxiao_site`;
CREATE TABLE `kaxiao_site` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `optdomain` varchar(1024) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `user` varchar(16) NOT NULL,
  `passwd` varchar(16) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `kaxiao_site` DISABLE KEYS */;
/*!40000 ALTER TABLE `kaxiao_site` ENABLE KEYS */;
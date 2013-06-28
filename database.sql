-- --------------------------------------------------------
--
-- 用户表
--
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` char(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `signa` varchar(200) NOT NULL,
  `site` varchar(100) NOT NULL,
  `power` char(10) NOT NULL DEFAULT 'user',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 插入默认用户，用户名admin，密码123456

INSERT INTO `user` (`id`, `user`, `password`, `email`, `signa`, `site`, `power`, `active`) VALUES
(1, 'admin', '14ee758e6d6981e802d996d1b27272064a8099ff201d15401e585ee0f4a214a683815071d785ed63b32e02bc06f45b7a23b86a11383082debe194e3aa5f5745e', 'admin@admin.com', '', '', 'admin', 1);

-- --------------------------------------------------------
--
-- 设置表
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `auto_load` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 插入设置表默认数据

INSERT INTO `setting` (`id`, `name`, `value`, `auto_load`) VALUES
(1, 'site_name', '精美图汇', 1),
(2, 'site_description', '美丽的图集', 1),
(3, 'allow_register', 'false', 1);

-- --------------------------------------------------------
--
-- 图集表
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `public` char(6) NOT NULL DEFAULT 'yes',
  `user` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `index` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  FOREIGN KEY (`user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- 图片表
--
CREATE TABLE `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album` int(11) NOT NULL,
  `file` varchar(1000) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `tag` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `album` (`album`),
  FOREIGN KEY (`album`) REFERENCES `album` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
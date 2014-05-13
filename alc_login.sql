SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for alc_login
-- ----------------------------
DROP TABLE IF EXISTS `alc_login`;
CREATE TABLE `alc_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `session_id` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `salt` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of alc_login
-- ----------------------------
INSERT INTO `alc_login` VALUES ('1', 'test', '8c456ad3562669e7a3c19da9e1f2f19c3728fe3ce827e6628bdf456039e533d3', 'kku4007dd08913ulp4sgnp6cp3', 'test@test.com', 'GIeP2nX');

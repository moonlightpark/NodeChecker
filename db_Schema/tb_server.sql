-- Create syntax for 'tb_server'

CREATE TABLE `tb_server` (
  `no` int unsigned NOT NULL AUTO_INCREMENT,
  `cmp_no` varchar(20) DEFAULT NULL,
  `node` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `port` varchar(5) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `last_block` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT '0',
  `last_resource` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT '0',
  `status` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT '-',
  `mining` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT '-',
  `regist_dt` varchar(10) NOT NULL,
  `regist_tm` varchar(8) NOT NULL,
  `regist_id` varchar(50) NOT NULL,
  `status_cd` varchar(5) NOT NULL DEFAULT 'ST001',
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3;

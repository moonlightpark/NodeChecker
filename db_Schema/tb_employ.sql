-- Create syntax for 'tb_employ'

CREATE TABLE `tb_employ` (
  `emp_id` varchar(20) NOT NULL,
  `cmp_no` varchar(20) NOT NULL,
  `emp_pwd` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `pw_changedt` varchar(10) DEFAULT NULL,
  `emp_nm` varchar(50) NOT NULL,
  `staff_lev` varchar(5) NOT NULL DEFAULT 'EM001',
  `tel_no` varchar(13) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email_addr` varchar(256) DEFAULT NULL,
  `ip_addr` varchar(15) DEFAULT '127.0.0.1',
  `last_login_tm` varchar(19) DEFAULT NULL,
  `regist_dt` varchar(10) NOT NULL,
  `regist_tm` varchar(8) NOT NULL,
  `regist_id` varchar(50) NOT NULL,
  `update_dt` varchar(10) DEFAULT NULL,
  `update_tm` varchar(8) DEFAULT NULL,
  `update_id` varchar(50) DEFAULT NULL,
  `status_cd` varchar(5) NOT NULL DEFAULT 'UM001',
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

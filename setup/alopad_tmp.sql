# Host: 10.98.21.10  (Version: 5.5.64-MariaDB)
# Date: 2020-08-10 13:43:40
# Generator: MySQL-Front 5.3  (Build 4.271)

/*!40101 SET NAMES latin1 */;

#
# Structure for table "ast_cdr"
#

DROP TABLE IF EXISTS `ast_cdr`;
CREATE TABLE `ast_cdr` (
  `ctype` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calldate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `number` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
  `agent` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `src` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `dst` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `station` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aid` int(11) DEFAULT NULL,
  `depid` int(11) DEFAULT NULL,
  `qid` int(11) DEFAULT NULL,
  `xferby` int(11) DEFAULT NULL,
  `xferto` int(11) DEFAULT NULL,
  `fwdby` int(11) DEFAULT NULL,
  `fwdto` int(11) DEFAULT NULL,
  `dcontext` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `channel` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `dstchannel` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `disposition` varchar(45) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `duration` int(11) NOT NULL DEFAULT '0',
  `billsec` int(11) NOT NULL DEFAULT '0',
  `score` smallint(3) DEFAULT NULL,
  `outgoing` tinyint(1) DEFAULT '0',
  `recordingfile` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `uniqueid` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `linkedid` varchar(32) CHARACTER SET utf8mb4 DEFAULT NULL,
  `lastdata` varchar(80) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `lastapp` varchar(80) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `did` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `numtype` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sequence` int(11) NOT NULL DEFAULT '0',
  `accountcode` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `amaflags` int(11) NOT NULL DEFAULT '0',
  `userfield` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `clid` varchar(80) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `cnum` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `cnam` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `outbound_cnum` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `outbound_cnam` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `dst_cnam` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `peeraccount` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `external_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  KEY `calldate` (`calldate`),
  KEY `dst` (`dst`),
  KEY `accountcode` (`accountcode`),
  KEY `uniqueid` (`uniqueid`),
  KEY `did` (`did`),
  KEY `recordingfile` (`recordingfile`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "ast_cdr"
#


#
# Structure for table "ast_cel"
#

DROP TABLE IF EXISTS `ast_cel`;
CREATE TABLE `ast_cel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventtype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eventtime` datetime NOT NULL,
  `cid_name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cid_num` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cid_ani` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cid_rdnis` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cid_dnid` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exten` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `context` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channame` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appname` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appdata` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amaflags` int(11) NOT NULL,
  `accountcode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uniqueid` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `linkedid` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peer` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userdeftype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniqueid_index` (`uniqueid`),
  KEY `linkedid_index` (`linkedid`),
  KEY `context_index` (`context`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "ast_cel"
#


#
# Structure for table "ast_dout"
#

DROP TABLE IF EXISTS `ast_dout`;
CREATE TABLE `ast_dout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `internal` tinyint(1) DEFAULT '1',
  `tollfree` tinyint(1) DEFAULT '1',
  `instate` tinyint(1) DEFAULT '0',
  `outstate` tinyint(1) DEFAULT '0',
  `mobile` tinyint(1) DEFAULT '0',
  `international` tinyint(1) DEFAULT '0',
  `note` varchar(500) CHARACTER SET utf8mb4 DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

#
# Data for table "ast_dout"
#

INSERT INTO `ast_dout` VALUES (1,'FULL',1,1,1,1,1,1,NULL,NULL,NULL),(2,'RESTRICTED',0,0,0,0,0,0,NULL,NULL,NULL),(3,'INTERNAL',1,0,0,0,0,0,NULL,NULL,NULL),(4,'STATE',1,1,1,0,0,0,NULL,NULL,NULL),(5,'NATIONAL',1,1,1,1,1,0,NULL,NULL,NULL),(6,'INTERNATIONAL',1,1,1,1,1,1,NULL,NULL,NULL);

#
# Structure for table "ast_events"
#

DROP TABLE IF EXISTS `ast_events`;
CREATE TABLE `ast_events` (
  `name` varchar(50) NOT NULL DEFAULT '',
  `enabled` tinyint(1) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "ast_events"
#

INSERT INTO `ast_events` VALUES ('AgentCalled',1,'When an agent rings'),('AgentComplete',1,'When an agent completes a call in queue'),('AgentConnect',1,'When an agent answers a call'),('AgentRingNoAnswer',1,'When an agent rings but no answer'),('DTMFEnd',1,'When an input receives from caller'),('DTMFStart',0,'When an input receives from caller'),('ExtensionStatus',1,'When Agent status changes, Idle, InUse ..'),('NewIncomingCall',1,'When a new call arrives into the system'),('QueueCallerAbandon',1,NULL),('QueueCallerJoin',1,NULL),('QueueMemberStatus',0,NULL);

#
# Structure for table "ast_globals"
#

DROP TABLE IF EXISTS `ast_globals`;
CREATE TABLE `ast_globals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `var` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `note` varchar(500) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `var` (`var`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

#
# Data for table "ast_globals"
#

INSERT INTO `ast_globals` VALUES (1,'DEVMODE','1','Generates more verbose on hangup',NULL,NULL),(2,'MULTIPLUG','0','Disable/Enable Multi login on stations',NULL,NULL),(3,'EXTERNAL','1','Disable/Enable plug on External',NULL,NULL),(4,'STATEID','1',NULL,NULL,NULL),(5,'STATENAME','Tehran',NULL,NULL,NULL),(6,'STATECODE','021',NULL,NULL,NULL),(7,'STNFIRSTLOGGER','1',NULL,NULL,NULL),(8,'DEFAULTROUTEID','1',NULL,NULL,NULL);

#
# Structure for table "ast_queues"
#

DROP TABLE IF EXISTS `ast_queues`;
CREATE TABLE `ast_queues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `depid` int(6) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `name_fa` varchar(100) NOT NULL,
  `by247` tinyint(1) NOT NULL DEFAULT '1',
  `recalert` tinyint(1) NOT NULL DEFAULT '1',
  `preplay` varchar(100) DEFAULT NULL,
  `postplay` varchar(100) DEFAULT NULL,
  `recording` tinyint(1) NOT NULL DEFAULT '1',
  `voting` tinyint(1) NOT NULL DEFAULT '1',
  `intro` varchar(5) NOT NULL DEFAULT 'id',
  `start` time DEFAULT NULL,
  `end` time DEFAULT NULL,
  `dout_policy` tinyint(3) DEFAULT NULL,
  `dout_routeid` smallint(6) DEFAULT NULL,
  `_StrategyIn` varchar(30) NOT NULL DEFAULT 'rrmemory',
  `_Musicclass` varchar(255) DEFAULT 'default',
  `_Timeout` tinyint(3) DEFAULT '20',
  `_Maxlen` tinyint(3) DEFAULT '0',
  `_Autofill` varchar(5) DEFAULT 'no',
  `_AnnounceHoldTime` varchar(10) DEFAULT 'no',
  `_AnnouncePosition` varchar(10) DEFAULT 'yes',
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "ast_queues"
#

INSERT INTO `ast_queues` VALUES (1,1,1,'OPERATOR','?????',1,1,NULL,NULL,1,1,'ext',NULL,NULL,1,1,'rrmemory','default',20,0,'no','no','yes',NULL,'2020-07-29 14:00:37');

#
# Structure for table "ast_scores"
#

DROP TABLE IF EXISTS `ast_scores`;
CREATE TABLE `ast_scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent` varchar(40) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `score` smallint(6) NOT NULL DEFAULT '0',
  `uniqueid` varchar(40) DEFAULT NULL,
  `linkedid` varchar(40) DEFAULT NULL,
  `location` varchar(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "ast_scores"
#


#
# Structure for table "ast_trunks"
#

DROP TABLE IF EXISTS `ast_trunks`;
CREATE TABLE `ast_trunks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enabled` tinyint(1) DEFAULT '1',
  `name` varchar(50) DEFAULT NULL,
  `host` varchar(100) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `gsm` tinyint(1) DEFAULT '0',
  `prepend` varchar(20) DEFAULT NULL,
  `defaultroute` tinyint(1) DEFAULT NULL,
  `created_by` smallint(6) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "ast_trunks"
#

INSERT INTO `ast_trunks` VALUES (1,1,'TCI','10.98.21.20',NULL,0,NULL,NULL,NULL,'2020-07-29 14:08:35');

#
# Structure for table "departments"
#

DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "departments"
#

INSERT INTO `departments` VALUES (1,'EMDAD',NULL,'2020-04-21 17:54:04');

#
# Structure for table "featurecodes"
#

DROP TABLE IF EXISTS `featurecodes`;
CREATE TABLE `featurecodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enabled` tinyint(1) DEFAULT '1',
  `code` varchar(30) NOT NULL DEFAULT '',
  `filename` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

#
# Data for table "featurecodes"
#

INSERT INTO `featurecodes` VALUES (18,1,'03','ST20200620020047BY200.wav',8060,'2020-06-20 02:49:48'),(19,1,'04','ST20200620020047BY200.wav',8060,'2020-06-20 02:52:32'),(20,1,'14','ST20200620020047BY200.wav',8060,'2020-06-20 14:48:24');

#
# Structure for table "logwatch"
#

DROP TABLE IF EXISTS `logwatch`;
CREATE TABLE `logwatch` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `station_id` int(11) DEFAULT NULL,
  `queue_id` int(11) DEFAULT NULL,
  `logged_in` datetime DEFAULT NULL,
  `logged_in_by` varchar(100) DEFAULT NULL,
  `logged_out` datetime DEFAULT NULL,
  `logged_out_by` int(11) DEFAULT NULL,
  `duration` int(20) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `note` varchar(255) DEFAULT '',
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "logwatch"
#


#
# Structure for table "plugwatch"
#

DROP TABLE IF EXISTS `plugwatch`;
CREATE TABLE `plugwatch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugged` tinyint(3) DEFAULT '1',
  `agent_id` int(11) DEFAULT NULL,
  `station_id` int(11) DEFAULT NULL,
  `plugtime` datetime DEFAULT NULL,
  `plugged_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "plugwatch"
#


#
# Structure for table "queuebinds"
#

DROP TABLE IF EXISTS `queuebinds`;
CREATE TABLE `queuebinds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enabled` int(1) DEFAULT '1',
  `queue_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL DEFAULT '0',
  `station_id` int(11) DEFAULT NULL,
  `binded` tinyint(1) DEFAULT '0',
  `binded_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

#
# Data for table "queuebinds"
#


#
# Structure for table "queuelog"
#

DROP TABLE IF EXISTS `queuelog`;
CREATE TABLE `queuelog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `callid` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `queuename` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `serverid` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `agent` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `event` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `data1` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `data2` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `data3` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `data4` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `data5` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `queue` (`queuename`),
  KEY `callindex` (`callid`),
  KEY `event` (`event`),
  KEY `timeindex` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "queuelog"
#


#
# Structure for table "stations"
#

DROP TABLE IF EXISTS `stations`;
CREATE TABLE `stations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `peer` varchar(20) DEFAULT NULL,
  `secret` varchar(50) DEFAULT NULL,
  `type` varchar(20) DEFAULT 'friend',
  `context` varchar(30) DEFAULT 'ava-internal',
  `host` varchar(20) DEFAULT 'dynamic',
  `qualify` varchar(255) DEFAULT 'yes',
  `registered` tinyint(1) DEFAULT '0',
  `ip` varchar(15) DEFAULT NULL,
  `lastregister` datetime DEFAULT NULL,
  `lastunregister` datetime DEFAULT NULL,
  `max` tinyint(3) DEFAULT '1',
  `loggers` tinyint(3) NOT NULL DEFAULT '0',
  `lastlogger` varchar(10) DEFAULT NULL,
  `dout` tinyint(1) DEFAULT '0',
  `dout_policy` tinyint(3) DEFAULT NULL,
  `dout_routeid` tinyint(3) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

#
# Data for table "stations"
#

INSERT INTO `stations` VALUES (1,1,'S0001','S0001','friend','ava-internal','dynamic','yes',0,NULL,NULL,NULL,1,0,NULL,1,3,1,NULL,NULL),(2,1,'S0002','S0002','friend','ava-internal','dynamic','yes',0,NULL,NULL,NULL,1,0,NULL,1,3,1,NULL,NULL),(3,1,'S0003','S0003','friend','ava-internal','dynamic','yes',0,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL),(4,1,'S0004','S0004','friend','ava-internal','dynamic','yes',0,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL),(5,1,'S0005','S0005','friend','ava-internal','dynamic','yes',0,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL),(6,1,'S0006','S0006','friend','ava-internal','dynamic','yes',0,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL),(7,1,'S0007','S0007','friend','ava-internal','dynamic','yes',0,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL);

#
# Structure for table "studio"
#

DROP TABLE IF EXISTS `studio`;
CREATE TABLE `studio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "studio"
#


#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `plugged` tinyint(1) NOT NULL DEFAULT '0',
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `fullname` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `fullname_fa` varchar(255) DEFAULT NULL,
  `access` smallint(6) DEFAULT '6',
  `ext` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `external` varchar(15) DEFAULT NULL,
  `station` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `mobile` varchar(11) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `mobile_s` varchar(11) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(60) CHARACTER SET latin1 DEFAULT NULL,
  `email_s` varchar(60) CHARACTER SET latin1 DEFAULT NULL,
  `pin` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `agent` tinyint(1) NOT NULL DEFAULT '0',
  `ivradmin` tinyint(1) NOT NULL DEFAULT '0',
  `divert` tinyint(1) NOT NULL DEFAULT '0',
  `dnd` tinyint(1) NOT NULL DEFAULT '0',
  `vm` tinyint(1) NOT NULL DEFAULT '0',
  `fax` tinyint(1) DEFAULT '0',
  `did` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `record_in` tinyint(1) NOT NULL DEFAULT '0',
  `record_out` tinyint(1) NOT NULL DEFAULT '0',
  `vote_in` tinyint(1) NOT NULL DEFAULT '0',
  `vote_out` tinyint(1) NOT NULL DEFAULT '0',
  `callwaiting` tinyint(1) DEFAULT '0',
  `campon` tinyint(1) DEFAULT '0',
  `depid` tinyint(1) DEFAULT NULL,
  `secid` tinyint(1) DEFAULT NULL,
  `ringtime` smallint(6) NOT NULL DEFAULT '40',
  `dout_policy` smallint(3) DEFAULT NULL,
  `dout_routeid` smallint(6) DEFAULT NULL,
  `dout_timer` int(11) NOT NULL DEFAULT '0',
  `notify_missmail` tinyint(1) DEFAULT '0',
  `notify_vmmail` tinyint(1) DEFAULT '0',
  `notify_faxmail` tinyint(1) DEFAULT '0',
  `birthday` datetime DEFAULT NULL,
  `lsl` datetime DEFAULT NULL,
  `sessid` varchar(255) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `updated_by` smallint(6) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `ext` (`ext`),
  UNIQUE KEY `pin` (`pin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "users"
#


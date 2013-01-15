-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************


CREATE TABLE `tl_bbit_og_types` (

  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `label` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `prefix` varchar(50) NOT NULL default '',
  `namespace` varchar(1022) NOT NULL default '',
  PRIMARY KEY  (`id`)
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tl_page` (

  `bbit_og_handdown` char(1) NOT NULL default '',
  `bbit_og` char(1) NOT NULL default '',
  
  `bbit_og_title` varchar(255) NOT NULL default '',
  `bbit_og_type` varchar(255) NOT NULL default '',
  `bbit_og_customType` varchar(255) NOT NULL default '',
  `bbit_og_url` varchar(1022) NOT NULL default '',
  `bbit_og_image` blob NULL,
  `bbit_og_description` varchar(1022) NOT NULL default '',
  `bbit_og_site` varchar(255) NOT NULL default '',
  `bbit_og_curies` blob NULL,
  `bbit_og_custom` blob NULL,
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


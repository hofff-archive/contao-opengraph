-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************


CREATE TABLE `tl_page` (

  `bbit_og` varchar(255) NOT NULL default '',
  `bbit_og_type` varchar(255) NOT NULL default '',
  `bbit_og_title` varchar(255) NOT NULL default '',
  `bbit_og_site` varchar(255) NOT NULL default '',
  `bbit_og_url` varchar(1022) NOT NULL default '',
  `bbit_og_image` binary(16) NULL,
  `bbit_og_imageSize` varchar(255) NOT NULL default '',
  `bbit_og_description` varchar(1022) NOT NULL default '',
--  `bbit_og_curies` blob NULL,
--  `bbit_og_custom` blob NULL,
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


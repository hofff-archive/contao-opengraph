-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************


CREATE TABLE `tl_opengraph_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `label` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `prefix` varchar(50) NOT NULL default '',
  `namespace` varchar(1022) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tl_page` (
  `backboneit_opengraph_handdown` char(1) NOT NULL default '',
  `backboneit_opengraph` char(1) NOT NULL default '',
  `backboneit_opengraph_title` varchar(255) NOT NULL default '',
  `backboneit_opengraph_type` varchar(255) NOT NULL default '',
  `backboneit_opengraph_description` varchar(1022) NOT NULL default '',
  `backboneit_opengraph_image` varchar(255) NOT NULL default '',
  `backboneit_opengraph_street` varchar(255) NOT NULL default '',
  `backboneit_opengraph_geo` varchar(255) NOT NULL default '',
  `backboneit_opengraph_postal` varchar(255) NOT NULL default '',
  `backboneit_opengraph_locality` varchar(255) NOT NULL default '',
  `backboneit_opengraph_region` varchar(255) NOT NULL default '',
  `backboneit_opengraph_country` varchar(255) NOT NULL default '',
  `backboneit_opengraph_email` varchar(255) NOT NULL default '',
  `backboneit_opengraph_phone` varchar(255) NOT NULL default '',
  `backboneit_opengraph_fax` varchar(255) NOT NULL default '',
  `backboneit_opengraph_video` varchar(255) NOT NULL default '',
  `backboneit_opengraph_videodim` varchar(255) NOT NULL default '',
  `backboneit_opengraph_audio` varchar(255) NOT NULL default '',
  `backboneit_opengraph_audiotitle` varchar(255) NOT NULL default '',
  `backboneit_opengraph_audioartist` varchar(255) NOT NULL default '',
  `backboneit_opengraph_audioalbum` varchar(255) NOT NULL default '',
  `backboneit_opengraph_isbn` varchar(255) NOT NULL default '',
  `backboneit_opengraph_upc` varchar(255) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


-- --------------------------------------------------------

-- 
-- Table `tl_link_category`
-- 

CREATE TABLE `tl_link_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `published` char(1) NOT NULL default '',
  `title` varchar(255) NULL default '',
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_link_data`
-- 

CREATE TABLE `tl_link_data` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `published` char(1) NOT NULL default '0',
  `url_protocol` varchar(128) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `url_text` varchar(255) NOT NULL default '',
  `description` text NULL,
  `image` varchar(255) NOT NULL default '',
  `counter` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tl_module` (
  `delirius_linkliste_categories` text NULL,
  `delirius_linkliste_fesort` varchar(32) NOT NULL default '',
  `delirius_linkliste_template` varchar(64) NOT NULL default '',
  `delirius_linkliste_standardfavicon` varchar(255) NOT NULL default '',
  `delirius_linkliste_favicon` char(1) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


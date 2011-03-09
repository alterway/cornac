<?php
/*
   +----------------------------------------------------------------------+
   | Cornac, PHP code inventory                                           |
   +----------------------------------------------------------------------+
   | Copyright (c) 2010 - 2011                                            |
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,      |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.php.net/license/3_01.txt                                  |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Author: Damien Seguy <damien.seguy@gmail.com>                        |
   +----------------------------------------------------------------------+
 */

$mysql = new mysqli('localhost','root','','analyseur');

$tables = array('tpln');

$tables = array(
'akelos',
'artiphp',
'atrium',
'chuch',
'cmsimple',
'cnc',
'codeigniter',
'cornac',
'cp',
'doctrine',
'dolibarr',
'dompdf05',
'drupal7',
'ee',
'elgg',
'eventum',
'eyeos',
'ez',
'fudforum',
'joomla',
'kohana',
'magento',
'mediboard',
'mw',
'noloh',
'obm',
'openbiz',
'openx',
'orangehrm',
'oxid',
'phpbb',
'phpcodebrowser',
'phpinventory',
'phplib',
'phpmotion',
'phpmyadmin',
'phpmyfaq',
'phpmysport',
'phpnuke',
'pimcore',
'piwik',
'pligg',
'prestashop',
'rbs',
'roundcube',
'seagull',
'solar',
'spip',
'squirrelmail',
'sugar',
'symfony',
'tk',
'tomatocms',
'tpln',
'wordpress',
'xinc',
'zf',
);


foreach($tables as $table) {
print "$table debut\n";

$query = <<<SQL
CREATE TABLE `{$table}_2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `left` int(10) unsigned DEFAULT NULL,
  `right` int(10) unsigned DEFAULT NULL,
  `type` char(20) DEFAULT NULL,
  `code` varchar(10000) DEFAULT NULL,
  `file` varchar(255) DEFAULT 'prec',
  `line` int(11) DEFAULT NULL,
  `scope` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `level` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `file` (`file`),
  KEY `type` (`type`),
  KEY `left` (`left`),
  KEY `right` (`right`),
  KEY `code` (`code`(1000))
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 
SQL;
$mysql->query($query);

$mysql->query("insert into {$table}_2 select * from $table ");

$mysql->query("drop TABLE $table ");

$mysql->query("alter TABLE {$table}_2 rename $table ");

$mysql->query("Delete from {$table}_report_module");

$mysql->query("Delete from {$table}_report");

print "$table fin\n";
}

?>
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
   | Author: Damien Seguy <damien.seguy@alterway.fr>                      |
   +----------------------------------------------------------------------+
 */

include(dirname(dirname(dirname(__FILE__))).'/library/Cornac/Autoload.php');
spl_autoload_register('Cornac_Autoload::autoload');

// @todo this should come from the .ini file
$application = 'spotweb';
$ini = parse_ini_file('../ini/'.$application.'.ini', true);

/*
$ini = array('mysql' => array('active' => 1,
                              'dsn' => 'mysql:dbname=analyseur;host=127.0.0.1',
                              'username' => 'root',
                              'password' => ''),
             'cornac' => array('prefix' => 'tu' ) );
*/
$DATABASE = new Cornac_Database($ini);

$res = $DATABASE->query('SHOW TABLES LIKE "'.$ini['cornac']['prefix'].'%"');
if ($res->rowCount() == 0) {
    print $ini['cornac']['prefix']." doesn't exists in the database. Fix config file. Aborting. \n";
    die();
}

?>
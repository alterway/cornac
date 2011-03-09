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

include('../library/Cornac/Autoload.php');
spl_autoload_register('Cornac_Autoload::autoload');

$OPTIONS = array('ignore_ext' => array(), 'limit' => 0, 'ignore_dirs' => array(), );

$DATABASE = new Cornac_Database();
$a = $DATABASE->query_one_array("SELECT concat(fichier,';',if (sum(if (module='dieexit', 1,0)) > 0,'black','white')) AS file,
if (sum(if (module='dieexit', 1,0)) > 0,'black','white') as OK,
sum(if (module='dieexit', 1,0)) as module
    FROM <report> GROUP BY fichier ORDER BY module");

$image = new Cornac_Format_File2png();
$image->setArray($a);
$image->process();
$image->save('./file2png.png');

?>
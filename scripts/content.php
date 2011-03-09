#!/usr/bin/env php
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

if (!file_exists('../../inventory.ods')) {
    die("'../../inventory.ods' doesn't exists\n Aborting\n");
}

shell_exec('rm -rf extract');
mkdir('extract',0777);
copy('../../inventory.ods','./extract/inventory.zip');
shell_exec('cd extract; unzip inventory.zip; bbedit content.xml');
shell_exec('rm -rf extract');

?>
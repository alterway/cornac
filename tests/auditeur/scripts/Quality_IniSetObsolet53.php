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
ini_set('define_syslog_variables',1);
ini_set('register_globals',1);
ini_set('register_long_arrays',1);
ini_set('safe_mode',1);
ini_set('magic_quotes_gpc',1);
ini_set('magic_quotes_runtime',1);
ini_set('magic_quotes_sybase',1);

ini_get('define_syslog_variables');
ini_get('register_globals');
ini_get('register_long_arrays');
ini_get('safe_mode');
ini_get('magic_quotes_gpc');
ini_get('magic_quotes_runtime');
ini_get('magic_quotes_sybase');

?>
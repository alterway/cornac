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

$a = array_map('cb_1_1', range(1,3));
$b = call_user_func('cb_1_2');
$c = call_user_func_array('cb_1_3', range(1,4));

// second argument
usort($c, 'cb_2_1');
/*
                              'preg_replace_callback',
                              'uasort',
                              'uksort',
                              'array_reduce',
                              'array_walk',
                              'array_walk_recursive',
                              'mysqli_set_local_infile_handler'
                              */

// last argument
$x = array_diff_uassoc(range(1,2), range(3,4), 'cb_0_1');
$y = array_diff_ukey(range(1,2), range(3,4),range(5,6), 'cb_0_2');
/*
                   '',
                   'array_intersect_uassoc',
                   'array_intersect_ukey',
                   'array_udiff_assoc',
                   'array_udiff_uassoc',
                   'array_udiff',
                   'array_uintersect_assoc',
                   'array_uintersect_uassoc',
                   'array_uintersect',
                   'array_filter',
                   'array_reduce'
*/

?>
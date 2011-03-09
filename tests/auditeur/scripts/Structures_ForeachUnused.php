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

// k nor v
foreach($a as $k_variable => $v_variable) {
    
}

// OK
foreach($a as $K_variable => $V_variable) {
    $K_variable++;
    $V_variable++;
}

// k nor v as reference
foreach($a as $k_reference => &$v_reference) {
    
}

// OK
foreach($a as $K_reference => &$V_reference) {
    $K_reference++;
    $V_reference++;
}

?>
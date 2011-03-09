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


function function_one_reference(&$a) {}

function function_no_reference($b) {}

function function_two_references(&$c, $d) {}

function function_two_references_b($e, &$f) {}

function function_two_references_c(&$g, &$h) {}

class x {
function method_one_reference(&$a) {}

function method_no_reference($b) {}

function method_two_references(&$c, $d) {}

function method_two_references_b($e, &$f) {}

function method_two_references_c(&$g, &$h) {}

}
?>
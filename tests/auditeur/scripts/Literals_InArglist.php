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

function no_reference($arg) {}

no_reference($var);
no_reference('literal');
no_reference(true);

function one_reference(&$arg_ref) {}

one_reference($var);
one_reference(md5($var));
//one_reference('literal');
//one_reference(true);

function two_references(&$arg_ref1, &$arg_ref2) {}

two_references($var21, $var22);
two_references(md5($var23), md5($var24));
//two_references('literal', $var25);
//two_references($var26, 'literal');
//two_references('literal', 'literal');
two_references($var27, $var27);

?>
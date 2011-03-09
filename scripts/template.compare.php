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


$php = file_get_contents('prepare/template.tree.php');

preg_match_all("/(affiche_.*?)\(/", $php, $r);
//print_r($r[1]);

$liste = $r[1];

$php = file_get_contents('prepare/template.dot.php');

preg_match_all("/(affiche_.*?)\(/", $php, $r);
//print_r($r[1]);

$liste_dot = $r[1];

$manque = array_diff($liste, $liste_dot);
print_r($manque);
print count($manque)." reste à faire\n";
?>
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

$files = glob("prepare/*_regex.php");

$stats = array();
foreach($files as $file) {
    $regex = str_replace(array('prepare/','.php'), '', $file);
    $stats[$regex] = 0;
    $duration[$regex] = 0;
}

$file = file('/tmp/analyseur.log');
foreach($file as $id => $f) {
    list($a, $d, $foo) = explode("\t", $f);
    $stats[$a]++;
    $duration[$a] += $d;
}

asort($duration);
print_r($duration);

print "Total     : ".array_sum($duration)."\n";
print "Distincts : ".count($duration)."\n";
?>
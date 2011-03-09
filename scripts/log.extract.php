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



$file = file_get_contents('reference.log');

$total = preg_match_all("#Cycles = -1#i", $file, $r);

preg_match_all("#\n(.*)\n(.*)\nil reste (\d+) #i", $file, $r);

$trouve = count($r[1]);

print $trouve." fichiers sur un total de $total (".number_format(($total - $trouve)/$total * 100, 2)." %), pour ".array_sum($r[3])." Tokens\n";

foreach($r[1] as $x) {
    print "./tokenizeur.php -S -l -f $x -e | bbedit\n";
}

?>
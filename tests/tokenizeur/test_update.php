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
 
// @todo use getoption class
if ($id = array_search('-f', $argv)) {
    unset($argv[$id]);
    define('CREATE', true);
} else {
    define('CREATE', false);
}

array_shift($argv);
$args = $argv;

foreach($args as $arg) {
    if (!file_exists("./scripts/".$arg.".test.php")) {
        $module = glob("./scripts/".$arg.".*.test.php");
        if (count($module) == 0) {
            print "Test script './scripts/".$arg.".test.php' doesn't exist\n";
            die();
        }

        foreach($module as $m) {
            preg_match("#./scripts/(".$arg."\.\d*?)\.test.php#", $m, $r);

            print "./test_update.php -f $r[1]\n";
            shell_exec("./test_update.php -f $r[1]");

        }
        die();
    }

    if (!file_exists("./exp/".$arg.".test.exp")) {
        if (!CREATE) {
            print "Result script './exp/".$arg.".test.exp' doesn't exist\n";
        }
    }

    if (CREATE) {
      print "Modification de /exp/".$arg.".test.exp\n";
      shell_exec("cd ../../; php bin/tok -f tests/tokenizeur/scripts/".$arg.".test.php -I testsunitaires -g tree > tests/tokenizeur/exp/".$arg.".test.exp");

      $fichier = "exp/".$arg.".test.exp";
      $exp = file_get_contents($fichier);
      $exp = str_replace("Fichier de directives : ini/tokenizeur.ini\n", '', $exp);
      $exp = str_replace("Directives files : \n", '', $exp);
      $exp = str_replace("Cycles = -1\n", '', $exp);
      $exp = str_replace("No more tasks to work on. Finishing.\n",'', $exp);

      file_put_contents($fichier, $exp);
    } else {
      shell_exec("bbedit ./exp/".$arg.".test.exp");
      shell_exec("cd ../../; php bin/tok -f tests/tokenizeur/scripts/".$arg.".test.php  -I testsunitaires -g tree | bbedit");
    }
}

?>
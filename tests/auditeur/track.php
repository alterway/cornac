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

$tests = glob('./class.*.test.php');

foreach($tests as $id => $test) {
    $tests[$id] = substr($test,8, -9);
}


$scripts = glob('scripts/*');

foreach($scripts as $id => $script) {
    $scripts[$id] = substr($script,8, -4);
}

$diff = array_diff($tests, $scripts);
if(count($diff) != 0) {
    print "Some of the tests are missing their script : ".join(', ', $diff)."\n";
}

$diff = array_diff($scripts, $tests);
if(count($diff) != 0) {
    print "Some of the scripts are missing their tests : ".join(', ', $diff)."\n";
}


////////////////////////////////////////////////////////////////////////


$analyzers = array();

$analyzers_level1 = glob('../../auditeur/classes/[A-Z]*/*.php');

foreach($analyzers_level1 as $id => $analyzer) {
    $analyzer = substr($analyzer,23, -4);
    $analyzer = str_replace('/','_',$analyzer);
    
    $analyzers[] = $analyzer;
}

/*
$analyzers_level0 = glob('../../auditeur/classes/*.php');

foreach($analyzers_level0 as $id => $analyzer) {
    $analyzer = substr($analyzer,23, -4);
    
    if (in_array($analyzer, array('rendu'))) {
        unset($analyzers[$id]);
    } else {
        $analyzers[] = $analyzer;
    }
}
*/

$diff = array_diff($analyzers, $tests);
if(count($diff) != 0) {
    print "Some of the analyzers are not tested : (".count($diff).") ".join(', ', $diff)."\n";
}

////////////////////////////////////////////////////////////////////////


$alltest = file_get_contents('alltests.php');
preg_match_all("/'class\.(.*?)\.test\.php',/", $alltest, $r);
$alltest = $r[1];

$diff = array_diff($tests, $alltest);
if(count($diff) != 0) {
    print "Some of the tests are not in all tests : (".count($diff).") \n'class.".join(".test.php',\n'class.", $diff).".test.php',\n";
}


?>
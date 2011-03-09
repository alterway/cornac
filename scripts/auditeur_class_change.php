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
if (count($argv) != 3) {
    print "Usage : ./".basename(__FILE__)." origin destination\n";
    die();
}
$origin = $argv[1];
$destination = $argv[2];

print "Moving '$origin' to '$destination'\n";

if (!file_exists('../auditeur/classes/'.$origin.'.php')) {
    print "$origin is not a analyzer\n\n";
    die();
}

if (file_exists('../auditeur/classes/'.$destination.'.php')) {
    print "$destination already exists. Aborting\n\n";
    die();
}

// change values within the code 
// @attention This may be way too blind
$code = file_get_contents('../auditeur/classes/'.$origin.'.php');
$code = str_replace($origin, $destination, $code);
file_put_contents('../auditeur/classes/'.$origin.'.php',$code);

// change file name
shell_exec('git mv ../auditeur/classes/'.$origin.'.php ../auditeur/classes/'.$destination.'.php');

// change name in auditeur.php
$code = file_get_contents('../auditeur/auditeur.php');
$code = str_replace("'$origin',", "'$destination',", $code);
file_put_contents('../auditeur/auditeur.php',$code);

if (!file_exists('../tests/auditeur/scripts/'.$origin.'.php')) {
    print "$origin has no tests\n\n";
    die();
}

// @note no need to tests for tests presence : they are already useless without analyser.

// @attention This may be way too blind
// doing it in the script AND the phpunit class
$code = file_get_contents('../tests/auditeur/scripts/'.$origin.'.php');
$code = str_replace($origin, $destination, $code);
file_put_contents('../tests/auditeur/scripts/'.$origin.'.php', $code);

$code = file_get_contents('../tests/auditeur/class.'.$origin.'.test.php');
$code = str_replace($origin, $destination, $code);
file_put_contents('../tests/auditeur/class.'.$origin.'.test.php', $code);

// change file name in tests
shell_exec('git mv ../tests/auditeur/scripts/'.$origin.'.php ../tests/auditeur/scripts/'.$destination.'.php');
shell_exec('git mv ../tests/auditeur/class.'.$origin.'.test.php ../tests/auditeur/class.'.$destination.'.test.php');

// change filename in alltests
$code = file_get_contents('../tests/auditeur/alltests.php');
$code = str_replace("'class.$origin.test.php',", "'class.$destination.test.php',", $code);
file_put_contents('../tests/auditeur/alltests.php',$code);

?>
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

if (!isset($argv[1])) {
    die("Usage : mv [old analyzer name] [new analyzer name]\nMove an analyzer to a new skeleton for analyze, in classes directory. \n");
}

$old = trim($argv[1]);
$new = trim($argv[2]);

if (empty($old)) {
    print "'$old' must be non empty.\n";
    die();
}

if (preg_match_all('/[^a-zA-Z0-9_]/', $old, $r)) {
    print "'$old' should be a unique name, made of letters, figures and _ (Here, ".join(', ', $r[0])." were found).\n";
    die();
}


if (empty($new)) {
    print "'$new' must be non empty.\n";
    die();
}

if (preg_match_all('/[^a-zA-Z0-9_]/', $new, $r)) {
    print "'$new' should be a unique name, made of letters, figures and _ (Here, ".join(', ', $r[0])." were found).\n";
    die();
}

if (count(explode('_',$old)) != 2) {
    print "'$old' must contains one and only one _.\n";
    die();
}

$old_path = str_replace('_','/', $old);
if (!file_exists('classes/'.dirname($old_path))) {
    print "Old folder '".dirname($old_path)."' doesn't exist.\n";
    die();
}

if (!file_exists('classes/'.$old_path.'.php')) {
    print "'$old' doesn't exists.\n";
    die();
}

if (count(explode('_',$new)) != 2) {
    print "'$new' must contains one and only one _.\n";
    die();
}

$new_path = str_replace('_','/', $new);
if (!file_exists('classes/'.dirname($new_path))) {
    print "Folder '".dirname($new_path)."' doesn't exist.\n";
    die();
}

if (file_exists('classes/'.$new_path.'.php')) {
    print "'$new' already exists.\n";
    die();
}

shell_exec("git mv classes/$old_path.php classes/$new_path.php");

$code = file_get_contents("classes/$new_path.php");
$code = preg_replace("/ $old/", ' '.$new, $code);
file_put_contents("classes/$new_path.php", $code);

$code = file_get_contents("auditeur.php");
$code = preg_replace("/'$old',/", "'$new',", $code);
file_put_contents("auditeur.php", $code);

if (file_exists("../tests/auditeur/class.$old.test.php")) {
    shell_exec("git mv ../tests/auditeur/class.$old.test.php  ../tests/auditeur/class.$new.test.php ");
    shell_exec("git mv ../tests/auditeur/scripts/$old.php  ../tests/auditeur/scripts/$new.php ");
    
    $code = file_get_contents("../tests/auditeur/class.$new.test.php");
    $code = preg_replace("/class {$old}_Test extends/i", "class {$new}_Test extends", $code);
    file_put_contents("../tests/auditeur/class.$new.test.php", $code);
    
    $code = file_get_contents("../tests/auditeur/alltests.php");
    $code = preg_replace("/'class.$old.test.php',/", "'class.$new.test.php',", $code);
    file_put_contents("../tests/auditeur/alltests.php", $code);
} else {
    print "No test found. ";
}

print "$old moved to $new\n";
?>
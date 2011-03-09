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

$args = $argv;
if (get_arg($args, '-f')) { define('SHOW_FILES','true'); }
if (get_arg($args, '-d')) { define('SHOW_DIRS','true'); }
if (get_arg($args, '-e')) { define('SHOW_DIRS','true'); }

if ($format = get_arg_value($args, '-F', 'print_r')) {
    if (!in_array($format, array('print_r','csv','xml'))) { $format = 'print_r'; }
    define('FORMAT', $format);
}
if ($dir = get_arg_value($args, '-D', '.')) {
    if (!file_exists($dir)) { print "'$dir' doesn't exist\n"; die(); }
    define('DIR', $dir);
}

chdir($dir);

$liste = liste_directories_recursive('.');


$dirs = array_map('dirname', $liste);
$dirs = array_count_values($dirs);
if (SHOW_DIRS) { display($dirs); }

$files = array_map('basename', $liste);
$files = array_count_values($files);
if (SHOW_FILES) { display($files); }

$exts = array_map('cb_exts', $liste);
$exts = array_count_values($exts);
if (SHOW_EXTS) { display($exts); }

//print count($liste)." fichiers distincts\n";

function cb_exts($filename) {
    $filename = basename($filename);
    $pos = strrpos($filename, '.');
    return substr($filename, $pos);
}

function display($list) {
    if (FORMAT == 'print_r') {
        print_r($list);
    } elseif (FORMAT == 'xml') {
        print "<list>\n    <file>".join("</file>\n    <file>", $list)."</file>\n</list>\n";
    } elseif (FORMAT == 'csv') {
        print '"'.join("\"\n\"", $list).'"';
    }

    return true;
}

function get_arg(&$args, $option) {
    if ($id = array_search($option, $args)) {
        unset($args[$id]);
        $return = true;
    } else {
        $return = false;
    }
    return $return; 
}

function get_arg_value(&$args, $option=null, $default_value=null) {
    if ($id = array_search($option, $args)) {
        if (!isset($args[$id + 1])) { 
            unset($args[$id]);
            return $default_value;
        }
        $return = $args[$id + 1];
        unset($args[$id]);
        unset($args[$id + 1]);
    } else {
        $return = $default_value;
    }
    return $return; 
}
?>
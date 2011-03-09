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


$languages = array('fr','en');

include('../auditeur/classes/abstract/modules.php');
include('../auditeur/classes/abstract/noms.php');
include('../auditeur/classes/abstract/typecalls.php');
include('../auditeur/classes/abstract/functioncalls.php');

$files = glob('../auditeur/classes/*.php');

$strings = array();
$original = array();

foreach($files as $file) {
    include($file);
    
    preg_match('#../auditeur/classes/(.*)\.php#is', $file, $r);
    $class = $r[1];
    
    if (in_array($class, array('squelette','rendu','sommaire'))) { continue; }
    
    $x = new $class(NULL);
    
    $strings[$class] = array('title' => $x->gettitle(), 'desc' => $x->getdescription());
}

$original = $strings;

foreach($languages as $language) {
    print_r($original);
    $ini = '';
    foreach($strings as $analyzer => $infos) {
        extract($infos);
        $original_title = $original[$analyzer]['title'];
        $original_desc = $original[$analyzer]['desc'];

    // @todo check if we need to escape data in the .ini file. That may be needed for descption at least.
        if (strlen($title) > 50) { $title = substr($title, 0, 50).'...'; }
    
        $ini .= <<<INI
[$analyzer]
;original_title = "$original_title"
title = "$title"
;original_description = "$original_desc"
description = "$desc"

INI;
    }

    file_put_contents('../dict/translations.'.$language.'.ini', $ini);
}
?>
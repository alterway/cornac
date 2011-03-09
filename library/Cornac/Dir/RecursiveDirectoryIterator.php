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
class Cornac_Dir_RecursiveDirectoryIterator {
    function list_files($directory) {
        $files = new RecursiveDirectoryIterator($directory, 
                                                FilesystemIterator::KEY_AS_PATHNAME | 
                                                FilesystemIterator::CURRENT_AS_FILEINFO );
        $iterator = new RecursiveIteratorIterator($files);
        // @doc ignore some file extensions
        $regex = new Cornac_Dir_IgnoreFileExtensionFilter($iterator);
        // @doc ignore files without extension
        $regex2 = new Cornac_Dir_IgnoreFileNoExtensionFilter($regex);
        // @doc ignore files starting with .
        $regex3 = new Cornac_Dir_InvertedRegexIterator($regex2, '#/\.#', RecursiveRegexIterator::GET_MATCH);
        // @doc ignore some file prefix
        $regex4 = new Cornac_Dir_IgnoreFilePrefixFilter($regex3);
        // @doc ignore some directories
        $regex5 = new Cornac_Dir_IgnoreDirsFilter($regex4);

        $list = array();
        foreach($regex5 as $filename => $current) {
            $list[] = $filename;
        }
        
        return $list;
    }
}

?>
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
class Cornac_Dir_InvertedRegexIterator extends RegexIterator {
    // @todo watch out for the default values. Couldn't find them in the docs. 
    public function __construct(Iterator $iterator , $regex , $mode = 0, $flags = 0, $preg_flags = 0 ) {
        parent::__construct($iterator , $regex , $mode, $flags, $preg_flags );
    }

    public function accept() {
        return !parent::accept();
    }
}

?>
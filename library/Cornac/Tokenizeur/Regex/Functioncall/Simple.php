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

class Cornac_Tokenizeur_Regex_Functioncall_Simple extends Cornac_Tokenizeur_Regex {
    protected $tname = 'functioncall_simple_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_STRING, 
                     T_ARRAY, 
                     T_ISSET, 
                     T_PRINT, 
                     T_ECHO, 
                     T_EXIT, 
                     T_EMPTY, 
                     T_LIST, 
                     T_UNSET,
                     T_EVAL,
                     T_STATIC,
                     T_NAMESPACED_NAME);
    }

    function check($t) {
        if (!$t->hasNext() ) { return false; }

// @note _nsname
        if ($t->hasPrev() && 
            $t->getPrev()->checkOperator('\\')) { return false; }

        if ($t->hasPrev(2) && 
            $t->getPrev()->checkOperator('&') &&
            $t->getPrev(1)->checkToken(T_FUNCTION)) { return false; }

        if ($t->hasPrev() && 
            $t->getPrev()->checkToken(T_FUNCTION)) { return false; }

        if ( $t->checkNotFunction()) { return false; }
        if ( $t->getNext()->checkNotClass('arglist')) { return false; }

        if ($t->getNext(1)->checkOperator(array('{','(')) ||
            $t->getNext(1)->checkClass('parenthesis')) { return false; }

        $this->args = array(0 , 1);
        $this->remove[] = 1;

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true; 
    }
}
?>
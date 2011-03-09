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

class Cornac_Tokenizeur_Regex_Constant_Normal extends Cornac_Tokenizeur_Regex {
    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_STRING);
    }
    
    function check($t) {
        if (!$t->hasNext()) { return false; }
        if (!$t->hasPrev()) { return false; }

        if ($t->checkNotClass('Token')) { return false; } 
        if ($t->checkNotToken(array(T_STRING, 
                                    T_DIR, 
                                    T_FILE, 
                                    T_FUNC_C, 
                                    T_LINE, 
                                    T_METHOD_C, 
                                    T_NS_C, 
                                    T_CLASS_C))) { return false; }
        if ($t->getNext()->checkOperator(array('(','::','{', '\\'))) { return false; }

        if ($t->getNext()->checkCode(':')) {
            if ($t->getPrev()->checkNotOperator(array('->','::','?','.', '+','-','*','/','%',':','!')) && 
                $t->getPrev()->checkNotToken(array(T_CASE, T_NEW)) && 
               !$t->getPrev()->checkForAssignation() &&
               !$t->getPrev()->checkForComparison() &&
               !$t->getPrev()->checkForLogical() && 
               !$t->getPrev()->checkForCast() ) { return false; }
        }
        if ($t->getNext()->checkToken(array(T_VARIABLE, T_AS))) { return false; }
        if ($t->getNext()->checkClass(array('variable','affectation','arglist'))) { return false; }

// @note ,'::' no use here
        if ($t->getPrev()->checkCode(array('->','\\'))) { return false; }
        if ($t->getPrev()->checkToken(array(T_CLASS, 
                                            T_EXTENDS, 
                                            T_IMPLEMENTS, 
                                            T_NAMESPACE, 
                                            T_USE,
                                            T_AS,
                                            T_GOTO))) { return false; }

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true; 
    }
}
?>
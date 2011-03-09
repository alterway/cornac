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

class Cornac_Tokenizeur_Regex_Logical extends Cornac_Tokenizeur_Regex {
    protected $tname = 'logical_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_LOGICAL_OR, T_LOGICAL_AND, T_LOGICAL_XOR, 
                     T_BOOLEAN_OR, T_BOOLEAN_AND, '&','|','^' );
    }
    
    function check($t) {
        if (!$t->hasPrev() ) { return false; }
        if (!$t->hasNext() ) { return false; }

        if ($t->checkNotClass('Token')) { return false; }
        if ($t->getPrev()->checkClass(array( 'Token', 'arglist','sequence','block'))) { return false;}
        if ($t->getPrev()->checkOperator(array( ')',',',']','}','"'))) { return false;}
        if ($t->getPrev()->checkForAssignation()) { return false;}

        if ($t->getNext()->checkClass(array('Token', 'arglist','sequence','block'))) { return false;}

        if (($t->hasPrev(2) && (((!$t->getPrev(1)->checkBeginInstruction()) && 
                                 $t->getPrev(1)->checkNotOperator(')') ))) ) {  return false; }
        if ($t->hasNext(2) && $t->getNext(1)->checkClass(array('parenthesis','arglist'))) { return false; }
        if ((!$t->hasNext(2) || 
            ( $t->getNext(1)->checkNotOperator(array('[','->','{','(','::')) && 
             !$t->getNext(1)->checkForAssignation()))
            ) {
            
            $this->args   = array(-1, 0, 1);
            $this->remove = array(-1, 1);

            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
            return true; 
        } 
        return false;
    }
}
?>
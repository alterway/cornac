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

class Cornac_Tokenizeur_Regex_Sequence_Class extends Cornac_Tokenizeur_Regex {
    protected $tname = 'sequence_class_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(Cornac_Tokenizeur_Token::ANY_TOKEN);
    } 

    function check($t) {
        if (!$t->hasNext() ) { return false; }
        
        if (!$t->checkForBlock(true) && 
             $t->checkNotClass(array('codephp','variable'))) { return false; } 

        if (!$t->getNext()->checkForBlock(true) && 
            !$t->getNext()->checkForVariable() &&
             $t->getNext()->checkNotClass(array('_new',
                                                'concatenation')) ) { return false; } 

        if ( (!$t->hasNext(1) || 
               ( $t->getNext(1)->checkNotCode(array('or','and','xor','->','[','::',')','.','^','&','|','||','&&','++','--','+','-','/','*','%')) &&
                !$t->getNext(1)->checkForAssignation()) &&
                 $t->getNext(1)->checkNotClass('arglist'))
               ) { 

            if ($t->hasNext(1) && $t->getNext(1)->checkOperator(array('=','->',',','('))) { return false; }
            if ($t->hasPrev() && ($t->getPrev()->checkOperator(array(')',':','->','.','?','"','*','/','%','+','-')) ||
                                  $t->getPrev()->checkClass(array('parenthesis','arglist')) ||
                                  $t->getPrev()->checkForAssignation() || 
                                  $t->getPrev()->checkForLogical() ||
                                  $t->getPrev()->checkToken(array(T_ELSE, T_ABSTRACT, T_DO, T_STATIC))) ) { return false; }

            $var = $t->getNext(1); 
            $this->args   = array( 0, 1 );
            $this->remove = array( 1 );
                        
            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." identifies a sequence ( ".get_class($t).", ".get_class($t->getNext())." )  (".$this->getTname().")");
            return true; 
        } 
        return false;
    }

}
?>
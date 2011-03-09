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

class Cornac_Tokenizeur_Regex_Ifthen_Elsesimple extends Cornac_Tokenizeur_Regex {
    protected $tname = 'ifthenelse_simple_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_ELSE);
    }
    
    function check($t) {
        if (!$t->hasNext() ) { return false; }

        if ($t->checkNotToken(T_ELSE)) { return false;}
        if ($t->getNext()->checkClass('block')) { return false;}

        if ($t->getNext()->checkForBlock(true) && 
            (!$t->hasNext(1) || 
              ($t->getNext(1)->checkOperator(';') ||
               $t->getNext(1)->checkToken(T_CLOSE_TAG)))
            ) {

            $regex = new Cornac_Tokenizeur_Regex_Model('block',array(0), array(1));
            Cornac_Tokenizeur_Token::applyRegex($t->getNext(), 'block', $regex);

            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => block (from ".get_class($t).") (".$this->getTname().")");
            return false; 
        } 

        if ( ($t->getNext()->checkForBlock(true) ||
              $t->getNext()->checkClass(array('concatenation','_constant','sign','not','noscream','invert','parenthesis')) ||
              $t->getNext()->checkForVariable()
              )
            ) {

            if ($t->getNext(1)->checkForAssignation()) { return false; }
            if ($t->getNext(1)->checkOperator(array('.','->','[','::'))) { return false; }
            if ($t->getNext(1)->checkClass(array('Token','arglist')) &&
                $t->getNext(1)->checkNotEndInstruction()) { return false; }
            
            $regex = new Cornac_Tokenizeur_Regex_Model('block',array(0), array());
            Cornac_Tokenizeur_Token::applyRegex($t->getNext(), 'block', $regex);

            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => block (from instruction) (".$this->getTname().")");
            return false; 
        } 

        return false;
    }
}
?>
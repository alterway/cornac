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

class Cornac_Tokenizeur_Regex_Ifthen_Elseifsimple extends Cornac_Tokenizeur_Regex {
    protected $tname = 'ifthenelseif_simple_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_IF,T_ELSEIF);
    }
    
    function check($t) {
        if (!$t->hasNext(1) ) { return false; }
        if ($t->getNext()->checkNotClass('parenthesis')) { return false; }

        if ($t->getNext(1)->checkForBlock(true)) {
            if ($t->hasNext(2) && $t->getNext(2)->checkForAssignation()) {
                return false;
            }

            if ($t->hasNext(2) && $t->getNext(2)->checkOperator(array('->','[','::'))) {
                return false;
            }
            
            $remove = array();
            if ($t->hasNext(2) && 
                $t->getNext(2)->checkOperator(';')) {
                $remove = array(1);
            }
            $regex = new Cornac_Tokenizeur_Regex_Model('block',array(0),$remove);
            Cornac_Tokenizeur_Token::applyRegex($t->getNext(1), 'block', $regex);

            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => block 1 (".$this->getTname().")");
            return false; 
        } 

        if ($t->getNext(1)->checkNotClass('Token') &&
            $t->getNext(2)->checkOperator(';')) {

            $regex = new Cornac_Tokenizeur_Regex_Model('block',array(0), array(1));
            Cornac_Tokenizeur_Token::applyRegex($t->getNext(1), 'block', $regex);

            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => block 2 (".$this->getTname().")");
            return false; 
        } 
        
        return false;
    }
}
?>
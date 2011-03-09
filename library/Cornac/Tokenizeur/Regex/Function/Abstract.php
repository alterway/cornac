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

class Cornac_Tokenizeur_Regex_Function_Abstract extends Cornac_Tokenizeur_Regex {
    protected $tname = 'function_abstract_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_FUNCTION);
    }    
    function check($t) {
        if (!$t->hasNext(2)) { return false; }
        
        if ($t->checkNotToken(array(T_FUNCTION))) { return false; }
        if ($t->getNext()->checkNotToken(T_STRING)) { return false; }
        if ($t->getNext(1)->checkNotClass('arglist')) { return false; }
        if ($t->getNext(2)->checkNotCode(';') ) { return false; }
        // @note : si ca compile et qu'on arrive ici, il y aura surement un abstract

        Cornac_Log::getInstance('tokenizer')->log(get_class($t->getNext())." => literals  (".$this->getTname().")");
        $regex = new Cornac_Tokenizeur_Regex_Model('literals',array(0), array());
        Cornac_Tokenizeur_Token::applyRegex($t->getNext(), 'literals', $regex);

        $this->args = array(1,2,3);
        $this->remove = array(1,2,3);
        
        if ($t->hasPrev() && $t->getPrev()->checkToken(array(T_PUBLIC, T_PROTECTED, T_PRIVATE, T_STATIC, T_FINAL, T_ABSTRACT))) {
            $this->args[] = -1;
            $this->remove[] = -1;
        }

        if ($t->hasPrev(1) && $t->getPrev(1)->checkToken(array(T_PUBLIC, T_PROTECTED, T_PRIVATE, T_STATIC, T_FINAL, T_ABSTRACT))) {
            $this->args[] = -2;
            $this->remove[] = -2;
        }

        if ($t->hasPrev(2) && $t->getPrev(2)->checkToken(array(T_PUBLIC, T_PROTECTED, T_PRIVATE, T_STATIC, T_FINAL, T_ABSTRACT))) {
            $this->args[] = -3;
            $this->remove[] = -3;
        }

        sort($this->args);
        sort($this->remove);

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true;
    }
}

?>
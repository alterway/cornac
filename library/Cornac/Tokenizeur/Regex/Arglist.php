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

class Cornac_Tokenizeur_Regex_Arglist extends Cornac_Tokenizeur_Regex {
    protected $tname = 'arglist_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array('(');
    }
 
    function check($t) {
        if (!$t->hasPrev( )) { return false; }
        if (!$t->hasNext(1)) { return false; }
        
        if ($t->checkNotClass('Token')) { return false; }

        // @note for it to be a function call, one need all this before
        if ($t->getPrev()->checkNotToken(array(T_STATIC, T_USE, T_FUNCTION)) && // @note crazy case 
            $t->getPrev()->checkNotFunction() &&
            $t->getPrev()->checkNotClass(array('variable','_array')) &&
            $t->getPrev()->checkNotCode('}')) { return false; }

        // @note wait for the namespace to be identified
        if ($t->getPrev(1)->checkOperator('\\')) { return false; }

        if ($t->getPrev()->checkOperator('}') && 
           $t->getPrev(2)->checkNotOperator('{')) {
                return false;
        }

        $var = $t->getNext(); 
        $this->args   = array();
        $this->remove = array();
        
        $pos = 1;
        
        while ($var->checkNotClass('Token') && 
               $var->checkNotOperator(')')  &&
               $var->getNext()->checkOperator(',')) {
            $this->args[]    = $pos;
            $this->remove[]  = $pos;
            $this->remove[]  = $pos + 1;
            
            $pos += 2;
            $var = $var->getNext();
            if (is_null($var)) { return false; }
            $var = $var->getNext();
            if (is_null($var)) { return false; }
            if ($var->checkOperator('(')) { return false; }
            if (is_null($var->getNext())) { return false; }
        }

        if ($var->checkOperator(')')) {
            $this->remove[] = $pos; // @note remove the final )
            
            if ($t->getPrev()->checkOperator('}') && 
                $var->getNext(1)->checkOperator('?')) {
                // @note arglist before a cdt ternary? no way.
                return false;
            }
            
            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." =>1 ".$this->getTname());
            return true; 
        } elseif ($var->getNext()->checkOperator(')')) {
            if ($var->checkClass('Token') &&
                $var->checkNotToken(T_USE)) { return false; }

            if ($t->getPrev()->checkOperator('}') && 
                $var->getNext(1)->checkOperator('?')) {
                // @note arglist before a cdt ternary? no way.
                return false;
            }
            
            if ($t->getPrev()->checkCode('echo') && 
                $var->getNext(1)->checkOperator(array('|','&','^'))) { return false; }
            
            $this->args[]    = $pos ;

            $this->remove[]  = $pos ;
            $this->remove[]  = $pos + 1;

            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." =>2 ".$this->getTname());
            return true; 
        } else {
            $this->args = array();
            $this->remove = array();
            return false;
        }
    }
}
?>
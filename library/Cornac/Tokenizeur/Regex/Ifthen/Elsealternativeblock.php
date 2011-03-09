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

class Cornac_Tokenizeur_Regex_Ifthen_Elsealternativeblock extends Cornac_Tokenizeur_Regex {
    protected $tname = 'ifthenelse_alternativeblock_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_IF);
    }
    
    function check($t) {
        if (!$t->hasNext(1) ) { return false; }

        if (!$t->checkToken(array(T_IF))) { return false;} 
        if ($t->getNext()->checkNotClass('parenthesis')) { return false; }
        if ($t->getNext(1)->checkNotCode(':')) { return false; } 
        if ($t->getNext(2)->checkNotClass('block')) { return false; } 
        
        $this->args   = array(1, 3);
        $this->remove = array(1, 2, 3);
        $var = $t->getNext(3);
        $pos = 4;

        while ($var->checkToken(T_ELSEIF) &&
               $var->getNext()->checkClass('parenthesis') &&
               $var->getNext(1)->checkCode(':') &&
               $var->getNext(2)->checkClass('block')
               ) {

            $this->args[] = $pos + 1;
            $this->args[] = $pos + 3;
            
            $this->remove[] = $pos;
            $this->remove[] = $pos + 1;
            $this->remove[] = $pos + 2;
            $this->remove[] = $pos + 3;
            
            $var = $var->getNext(3);
            $pos += 4;
        }

        if ($var->checkToken(T_ELSE) &&
            $var->getNext()->checkCode(':') &&
            $var->getNext(1)->checkClass('block')) {
            $this->args[] = $pos + 2;

            $this->remove[] = $pos;
            $this->remove[] = $pos + 1;
            $this->remove[] = $pos + 2;
            
            $var = $var->getNext(2);
            $pos += 3;
        }

        if ($var->checkToken(T_ENDIF)) {
            $this->remove[] = $pos;
            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
            return true; 
        }
        
        $this->args = array();
        $this->remove = array();
        return false;

    }
}
?>
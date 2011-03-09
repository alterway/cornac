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

class Cornac_Tokenizeur_Regex_For_Sequence extends Cornac_Tokenizeur_Regex {
    protected $tname = 'for_sequence_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_FOR);
    }
    
    function check($t) {
        if (!$t->hasNext(5)) { return false; }

        if ($t->checkNotToken(array(T_FOR))) { return false;}
        if ($t->getNext()->checkNotCode('(')) { return false;}
        
        if ($t->getNext(1)->checkNotClass('Token')  &&
            $t->getNext(2)->checkOperator(";")          &&
            $t->getNext(3)->checkClass('sequence')  &&
            $t->getNext(4)->checkOperator(")")          &&
            $t->getNext(5)->checkForBlock(true)
            
            ) {
            
              $this->args = array(2, 4, 6);
              $this->remove = array(1,2,3,4,5,6);
  
              Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => (Token; sequence) ".$this->getTname());
              return true;
        } elseif ($t->getNext(1)->checkNotClass('Token')  &&
                  $t->getNext(2)->checkOperator(";")          &&
                  $t->getNext(3)->checkClass('sequence')  &&
                  $t->getNext(4)->checkNotClass('Token')  &&
                  $t->getNext(5)->checkOperator(")")          &&
                  $t->getNext(6)->checkForBlock(true)
 
            
            ) {
            
              $this->args = array(2, 4, 5, 7);
              $this->remove = array(1,2,3,4,5,6,7);
  
              Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => (Token; sequence Token) ".$this->getTname());
              return true;
        } elseif ($t->getNext(1)->checkOperator(";")          &&
                  $t->getNext(2)->checkClass('sequence')  &&
                  $t->getNext(3)->checkNotClass('Token')  &&
                  $t->getNext(4)->checkOperator(")")          &&
                  $t->getNext(5)->checkForBlock(true)
            
            ) {
            
              $this->args = array(2, 3, 4, 6);
              $this->remove = array(1,2,3,4,5,6,7);
  
              Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => (;sequence Token) ".$this->getTname());
              return true;
        } else {
            return false;
        }
    }
}

?>
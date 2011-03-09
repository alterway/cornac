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

class Cornac_Tokenizeur_Regex_Ifthen_Elsemultiples extends Cornac_Tokenizeur_Regex {
    protected $tname = 'ifthenelse_multiples_regex';

    function __construct() {
        parent::__construct(array());
    }
    
    function getTokens() {
        return array(T_IF);
    }

    function check($t) {
        if (!$t->hasNext(4) ) { return false; }

        
        if ($t->getNext()->checkNotClass('parenthesis')) { return false;} 
        if ($t->getNext(1)->checkNotClass('block')) { return false;} 
        if ($t->getNext(2)->checkNotToken(T_ELSEIF)) { return false;} 
        if ($t->getNext(3)->checkNotClass('parenthesis')) { return false; }
        if ($t->getNext(4)->checkNotClass('block')) { return false; }

        $this->args   = array(1, 2, 4, 5);
        $this->remove = array(1, 2, 3, 4, 5);

        $var = $t->getNext(5);
        if (is_null($var)) {
           Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname()." ".count($this->args).": NULL :");
           return true; 
        }
        $pos = 5;
        while($var->checkToken(T_ELSEIF) &&
              $var->getNext()->checkClass('parenthesis') &&
              $var->getNext(1)->checkClass('block')) {
              
              $this->args[] = $pos + 2;
              $this->args[] = $pos + 3;

              $this->remove[] = $pos ;
              $this->remove[] = $pos + 1;
              $this->remove[] = $pos + 2;
              
              $pos += 3;
              $var = $var->getNext(2);
  
              // @note null? This script is ending, so is the ifthen
              if (is_null($var)) {
                  Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname()." ".count($this->args).": $var :");
                  return true; 
             }
        }

        if   ($var->checkToken(T_ELSEIF)) {
            $this->args = array();
            $this->remove = array();
            
            return false;
        }
        
        if   ($var->checkToken(T_ELSE)) {
            if ($var->getNext()->checkClass('block')) {

              $this->args[] = $pos + 2;

              $this->remove[] = $pos ;
              $this->remove[] = $pos + 1;              
            } else {
                $this->args = array();
                $this->remove = array();
                
                return false;
            }
        }
                    
        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname()." ".count($this->args).": $var :");
        return true; 
    }
}
?>
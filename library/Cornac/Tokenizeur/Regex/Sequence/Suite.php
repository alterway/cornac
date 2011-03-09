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

class Cornac_Tokenizeur_Regex_Sequence_Suite extends Cornac_Tokenizeur_Regex {
    protected $tname = 'sequence_suite_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(Cornac_Tokenizeur_Token::ANY_TOKEN);
    }
 
    function check($t) {
        if (!$t->hasNext() ) { return false; }

        if ($t->checkNotClass('sequence')) { return false; }
        if ($t->getNext()->checkForBlock(true) || 
            $t->getNext()->checkClass(array('parenthesis','codephp'))) { 

            $var = $t->getNext(1); 
            $this->args   = array( 0, 1 );
            $this->remove = array( 1 );
            
            $pos = 2;
            
            if (is_null($var)) {
                Cornac_Log::getInstance('tokenizer')->log(get_class($t)." merge ".count($this->args)." sequences (before, 1,  ".$this->getTname().")");
                return true; 
            }
            
            while ($var->checkForBlock(true) || $var->checkClass('codephp') ) {
                $this->args[]    = $pos ;
                
                $this->remove[]  = $pos;
                $pos += 1;
                $var = $var->getNext();
                if (is_null($var)) {
                    Cornac_Log::getInstance('tokenizer')->log(get_class($t)." merge ".count($this->args)." sequences (before, 2, ".$this->getTname().")");
                    return true; 
                }
            } 
            
            if ($var->checkForAssignation() ||
                $var->checkCode(array('or','and','xor','->','[','::',')','.','||','&&'))) {
                $this->args = array();
                $this->remove = array();
                return false;
            }
            
            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." merge ".count($this->args)." sequences (before, 3, ".$this->getTname().")");
            return true; 
        } 
        
        $this->args = array();
        $this->remove = array();
        return false;
    }

}
?>
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

class Cornac_Tokenizeur_Regex_Try extends Cornac_Tokenizeur_Regex {
    protected $tname = 'try_normal_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_TRY );
    }
    
    function check($t) {
        if (!$t->hasNext(1)) { return false; }

        if ($t->checkNotToken(T_TRY)) { return false; } 
        if ($t->getNext()->checkNotClass('block')) { return false; } 
        if ($t->getNext(1)->checkNotClass('_catch')) { return false; } 

        $this->args = array(1, 2);
        $this->remove = array(1,2);
        $var = $t->getNext(2);
        $pos = 3;
        
        if (is_null($var)) {
            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
            return true; 
        }
        
        while($var->checkClass('_catch')) {
            $this->args[] = $pos;
            $this->remove[] = $pos;

            $pos ++;
            $var = $var->getNext();
            if (is_null($var)) {
                Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
                return true; 
            }
        }
                
        if ($var->checkToken(T_CATCH)) {
            $this->args = array();
            $this->remove = array();
            return false;
        }

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true; 
    }
}
?>
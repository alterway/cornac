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

class Cornac_Tokenizeur_Regex_Nsname extends Cornac_Tokenizeur_Regex {
    protected $tname = 'nsname_normal_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_NS_SEPARATOR);
    }
    
    function check($t) {
        if (!$t->hasNext()) { return false; }
        
        // @note we need a real token, not just coincidence at code level
        if ($t->checkNotToken(T_NS_SEPARATOR)) { return false; }

// @note NSname may actually start by \ \htmlentities
        if ($t->getPrev()->checkToken(array(T_STRING))) { 
            $this->args = array(-1);
            $this->remove = array(-1);
        } else {
        // @note we use this to tell _nsname that this is a root call
            $this->args = array(0);
        }

        if ($t->getNext()->checkNotClass('Token')) { return false; }
        $this->args[] = 1;
        $this->remove[] = 0;
        $this->remove[] = 1;
        
        $var = $t->getNext(1);
        $pos = 1;
        while($var->checkOperator('\\')) {
            $this->args[] = $pos + 2;
            $this->remove[] = $pos + 1;
            $this->remove[] = $pos + 2;
            
            $var = $var->getNext(1);
            $pos += 2;
        }
        
        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true; 
    }
}
?>
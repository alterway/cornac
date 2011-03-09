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

class Cornac_Tokenizeur_Regex_Case_Block extends Cornac_Tokenizeur_Regex {
    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_CASE);
    }
    
    function check($t) {
        if (!$t->hasNext()) { return false; }

        $this->args = array(0, 1 );
        $this->remove = array(1, 2);
        
        if ($t->getNext()->checkClass('Token')) { return false; }
        if ($t->getNext(1)->checkNotCode(array(':',';'))) { return false; }
        if ($t->getNext(2)->checkNotClass('block')) { return false; }

        if ($t->getNext(3)->checkNotClass(array('_default','_case')) &&
            $t->getNext(3)->checkNotCode('}') &&
            $t->getNext(3)->checkNotToken(array(T_CASE, T_DEFAULT, T_ENDSWITCH))) { return false;}

        $this->args[] = 3;
        $this->remove[] = 3;

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true; 
    }
}
?>
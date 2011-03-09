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

class Cornac_Tokenizeur_Regex_Codephp_Withsemicolon extends Cornac_Tokenizeur_Regex {
    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_OPEN_TAG);
    }

    function check($t) {
        if (!$t->hasNext(2)) { return false; }
        
        if ($t->getNext()->checkClass('Token')) { return false; }
        if ($t->getNext(1)->checkNotCode(';')) { return false; }
        if ($t->getNext(2)->checkNotToken(T_CLOSE_TAG)) { return false; }

        if ($t->hasNext(3) && $t->getNext(3)->checkToken(T_OPEN_TAG)) {
            // @note empty raw text
            return false;
        }

        if ($t->hasNext(4) && $t->getNext(4)->checkToken(T_OPEN_TAG)) {
            // @note non empty raw text
            return false;
        }
        
        $this->args = array(1);
        $this->remove = array(1,2,3);
        
        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => codePHP (".$this->getTname().")");
        return true;
    }
}

?>
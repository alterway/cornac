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

class Cornac_Tokenizeur_Regex_Codephp_Empty extends Cornac_Tokenizeur_Regex {
    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_OPEN_TAG);
    }
    
    function check($t) {
        if (!$t->hasNext()) { return false; }

        $this->args = array();
        $this->remove = array(1);

        if ($t->hasNext(1) &&
            $t->getNext()->checkCode('php') && 
            $t->getNext(1)->checkToken(T_CLOSE_TAG)) {
            // @note also remove php string
            $this->remove[] = 2;
            // @note we go one. This is the <?php// case, which is wrongly parsed
        } elseif ($t->getNext()->checkNotToken(T_CLOSE_TAG)) { 
            return false; 
        }

        if ($t->hasNext(1) && 
            $t->getNext(1)->checkToken(T_INLINE_HTML)) {
                // @note avoid polluting rawtext_regex 
            return false;
        }

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true;
     }
}

?>
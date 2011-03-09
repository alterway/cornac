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

class Cornac_Tokenizeur_Regex_Codephp_Emptysequence extends Cornac_Tokenizeur_Regex {
    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_OPEN_TAG);
    }

    function check($t) {
        if (!$t->hasNext()) { return false; }
        
        $var = $t->getNext();
        if ($var->checkNotOperator(';')) { return false; }

        $var = $var->getNext();
        if ($var->checkNotClass('Token')) { return false; }
        
        $args = array();
        $remove = array(0);

        $regex = new Cornac_Tokenizeur_Regex_Model('sequence',$args, $remove);
        Cornac_Tokenizeur_Token::applyRegex($t->getNext(), 'sequence', $regex);

        
        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => codePHP (".$this->getTname().")");
        return false;
    }
}

?>
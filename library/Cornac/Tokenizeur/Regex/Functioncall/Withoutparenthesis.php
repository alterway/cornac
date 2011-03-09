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

class Cornac_Tokenizeur_Regex_Functioncall_Withoutparenthesis extends Cornac_Tokenizeur_Regex {
    protected $tname = 'functioncall_withoutparenthesis_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_PRINT,T_EXIT);
    }

    function check($t) {
        if (!$t->hasNext(1) ) { return false; }
        
        if ($t->getNext()->checkClass(array('Token','arglist'))) { return false; }
        if (!$t->getNext(1)->checkEndInstruction()) { return false; }

        $regex = new Cornac_Tokenizeur_Regex_Model('arglist',array(0), array());
        Cornac_Tokenizeur_Token::applyRegex($t->getNext(), 'arglist', $regex);

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => arglist (".$this->getTname().")");
        return false; 
    }
}
?>
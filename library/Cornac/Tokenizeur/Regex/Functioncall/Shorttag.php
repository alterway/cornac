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

class Cornac_Tokenizeur_Regex_Functioncall_Shorttag extends Cornac_Tokenizeur_Regex {
    protected $tname = 'functioncall_shorttag_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_OPEN_TAG);
    }

    function check($t) {
        if (!$t->hasNext(2) ) { return false; }
        
        if ($t->getNext()->checkNotCode(array("="))) { return false; }
        if ($t->getNext()->checkNotClass(array("Token"))) { return false; }
        if ($t->getNext(1)->checkClass(array("Token"))) { return false; }
        if ($t->getNext(2)->checkCode(array("[","::",'->','('))) { return false; }
        
        $args = array(0, 1);
        $delete = array( 1);
        
        if ($t->getNext(2)->checkCode(';')) {
            // @note forgotten final ;
            $delete[] = 2;
        }
        
        $regex = new Cornac_Tokenizeur_Regex_Model('functioncall',$args,$delete);
        Cornac_Tokenizeur_Token::applyRegex($t->getNext(), 'functioncall', $regex);

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => echo block (from <?= ) (".$this->getTname().")");
        return true;
    }
}
?>
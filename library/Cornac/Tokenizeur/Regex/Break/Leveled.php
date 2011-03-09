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

class Cornac_Tokenizeur_Regex_Break_Leveled extends Cornac_Tokenizeur_Regex {
    protected $tname = 'break_leveled_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_BREAK);
    }
    
    function check($t) {
        if (!$t->hasNext(1)) { return false; }

        if ($t->checkToken(T_BREAK) &&
            $t->getNext()->checkClass(array('literals','variable'))  &&
            $t->getNext(1)->checkCode(';')
            ) {

            $this->args = array(0, 1);
            $this->remove = array( 1);

            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
            return true; 
        } 

        if ($t->checkToken(T_BREAK) &&
            $t->getNext()->checkClass('parenthesis')  &&
            $t->getNext(1)->checkCode(';')
            ) {

            $this->args = array(0, 1);
            $this->remove = array( 1);

            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." =>2 ".$this->getTname());
            return true; 
        } 
        return false;
    }
}
?>
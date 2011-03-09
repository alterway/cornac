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

class Cornac_Tokenizeur_Regex_Method_Curly extends Cornac_Tokenizeur_Regex {
    protected $tname = 'method_curly_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array('{');
    }
    
    function check($t) {
        if (!$t->hasPrev(2) ) { return false; }
        if (!$t->hasNext(2) ) { return false; }

        if ( $t->getPrev(1)->checkNotClass(array('variable','property','_array','method','method_static','functioncall')) ) { return false; }
        if ( $t->getPrev()->checkNotCode('->')) { return false; }

        if ( $t->getNext()->checkClass('Token')) { return false; }
        if ( $t->getNext(1)->checkNotOperator('}')) { return false; }

        if ( $t->getNext(2)->checkOperator('(') &&
             $t->getNext(3)->checkOperator(')')) {
             
            $regex = new Cornac_Tokenizeur_Regex_Model('functioncall',array(0), array(-1, 0, 1));
            Cornac_Tokenizeur_Token::applyRegex($t->getNext(), 'functioncall', $regex);

            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => functioncall + '()' (".$this->getTname().")");
            return false; 
      }

      if ( $t->getNext(2)->checkClass('arglist')) {
           $regex = new Cornac_Tokenizeur_Regex_Model('functioncall',array(0, 2), array(-1, 1, 2));
           Cornac_Tokenizeur_Token::applyRegex($t->getNext(), 'functioncall', $regex);

            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => functioncall + arglist (".$this->getTname().")");
            return false; 
      }

      return false;
    }
}
?>
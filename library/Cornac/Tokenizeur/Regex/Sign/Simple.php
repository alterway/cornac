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

class Cornac_Tokenizeur_Regex_Sign_Simple extends Cornac_Tokenizeur_Regex {
    protected $tname = 'sign_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array('+','-');
    }
    
    function check($t) {
        if (!$t->hasPrev()) { return false; }
        if (!$t->hasNext()) { return false; }

        if ( $t->getNext()->checkNotClass(array('variable','property','_array', 'property_static',
                                                'method','method_static','functioncall',
                                                '_constant','constant_static','literals',
                                                'parenthesis', 'operation', 'cast','not'))) { return false; }
        if ( $t->getPrev()->checkClass(array('literals','variable','_array',
                                             'property','operation','sign',
                                             'functioncall','parenthesis','arglist',
                                             'ternaryop', )) ) { return false ;}

        if (!$t->getPrev()->checkBeginInstruction() &&
            !$t->getPrev()->checkForLogical() &&
             $t->getPrev()->checkNotOperator(array('~','&','|','@','!','-','+','>>','<<'))) { return false; }
             
        if ( $t->getPrev()->checkClass(array('variable','operation','property','property_static'))) { return false; }
        
        if ( $t->getNext(1)->checkOperator(array('->','[','*','/','%','++','--')) ) { return false; }
        if ( $t->getNext(1)->checkClass('arglist') ) { return false; }
        
        $this->args = array(0, 1 );
        $this->remove = array(1);

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true; 
    }
}
?>
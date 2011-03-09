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

class Cornac_Tokenizeur_Regex_Affectation_Simple extends Cornac_Tokenizeur_Regex {
    protected $tname = 'affectation_normal_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array('=',T_CONCAT_EQUAL,T_MUL_EQUAL,T_PLUS_EQUAL,T_MINUS_EQUAL,T_DIV_EQUAL,T_MOD_EQUAL,T_SR_EQUAL,T_AND_EQUAL,T_XOR_EQUAL, T_OR_EQUAL,T_SL_EQUAL);
    }
    
    function check($t) {
        if (!$t->hasPrev()) { return false; }
        if (!$t->hasNext(1)) { return false; }

        if ( $t->checkNotClass('Token')) { return false; }
        if ( $t->getNext(1)->checkNotOperator(array(';','}',')',',',':',']')) &&
             $t->getNext(1)->checkNotClass(array('sequence','block','_foreach','_for','rawtext')) &&
             $t->getNext(1)->checkNotToken(array(T_AS,T_CLOSE_TAG))
                ) { return false;}

        if ($t->hasPrev(1) && $t->getPrev(1)->checkOperator(array('&','$','::','@','->'))) { return false;}
        if (($t->getPrev()->checkNotClass(array('variable',
                                             'property',
                                             'opappend',
                                             'functioncall',
                                             'not',
                                             'noscream',
                                             'property_static',
                                             'reference',
                                             'cast',
                                             'sign',
                                             '_constant',)) && 
             $t->getPrev()->checkNotSubclass('variable'))) { return false; }
        if ($t->getNext()->checkNotClass(array('literals', 'variable','_array','sign','noscream',
                                             'property', 'method'  ,'ternaryop',
                                             'functioncall','operation','logical',
                                             'method_static','operation','ternaryop',
                                             'constant_static','property_static','_clone',
                                             'parenthesis','_new','cast','_constant','invert',
                                             'not','affectation','shell','bitshift','comparison',
                                             'reference','concatenation','variable',
                                             'property_static','postplusplus','preplusplus','inclusion',
                                             '_closure'))
            ) { return false; }

            $this->args = array(-1, 0, 1);
            $this->remove = array( -1, 1);
            
            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
            return true;
    }
}

?>
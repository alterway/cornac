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

class Cornac_Tokenizeur_Regex_New_Variable extends Cornac_Tokenizeur_Regex {
    protected $tname = 'new_variable_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_NEW);
    }
    
    function check($t) {
        if (!$t->hasNext(1)) { return false; }

        if ($t->getNext()->checkNotClass(array('variable',
                                               '_array',
                                               'method',
                                               'property',
                                               'property_static',
                                               'method_static',
                                               '_nsname'))) { return false; }

        if (!$t->getNext(1)->checkEndInstruction() &&
            !$t->getNext(1)->checkForLogical()) { return false; }

        $this->args = array(1);
        $this->remove = array(1);
        
        if ( $t->hasNext(3) &&
             $t->getNext(1)->checkOperator('(') &&
             $t->getNext(2)->checkOperator(')')
             ) {

            $this->args[]   = 2;
            $this->args[]   = 3;
            $this->remove[] = 2;
            $this->remove[] = 3;
       } 

        if ( $t->getNext(1)->checkClass('parenthesis')) {
            $this->args[]   = 2;
            $this->remove[] = 2;
        } 

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true; 
    }
}
?>
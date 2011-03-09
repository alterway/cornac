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

class Cornac_Tokenizeur_Token_Catch extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = '_catch';
    protected $exception = null;
    protected $variable = null;
    protected $block = null;
    
    function __construct($expression = null) {
        parent::__construct(array());
        
        $this->block = array_pop($expression);
        if (count($expression) == 2) {
            $this->exception = $this->makeProcessed('_catch_', $expression[0]);
            $this->variable  = $expression[1];
        } else {
            $this->stopOnError("Unexpected number of arguments received : (".count($expression)." instead of 3) in ".__METHOD__);
        }
    }

    function __toString() {
        return $this->getTname()." (".$this->exception." ".$this->variable.") ";
    }

    function getException() {
        return $this->exception;
    }

    function getVariable() {
        return $this->variable;
    }

    function getBlock() {
        return $this->block;
    }

    function neutralise() {
        $this->exception->detach();
        $this->variable->detach();
        $this->block->detach();
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Catch',
                    );
    }

}

?>
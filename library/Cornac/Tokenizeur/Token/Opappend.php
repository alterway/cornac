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

class Cornac_Tokenizeur_Token_Opappend extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = 'opappend';
    protected $variable = null;
    
    function __construct($variable) {
        parent::__construct(array());
        
        $this->variable = $variable[0];
        $this->setLine($this->variable->getLine());
    }

    function __toString() {
        return $this->getTname()." ".$this->code."[]";
    }

    function getVariable() {
        return $this->variable;
    }

    function neutralise() {
        $this->variable->detach();
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Opappend'
                    );
    }

}

?>
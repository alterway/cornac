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

class Cornac_Tokenizeur_Token_Array extends Cornac_Tokenizeur_Token_Variable {
    protected $tname = '_array';
    protected $variable = null;
    protected $index = null;

    function __construct($expression) {
        parent::__construct();
        
        if (is_array($expression) &&
            count($expression) == 2) {
            $this->variable = $expression[0];
            $this->index = $expression[1];
        } else {
            $this->stopOnError('No way we end up here : '.__METHOD__);
        }
    }
        
    function neutralise() {
        $this->variable->detach();
        $this->index->detach();

        $this->setCode($this->__toString());
    }

    function __toString() {
        return $this->getTname()." ".$this->variable."[".$this->index."]";
    }

    function getVariable() {
        return $this->variable;
    }

    function getIndex() {
        return $this->index;
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Array_Simple',
                     'Cornac_Tokenizeur_Regex_Array_Curly',
                     );
    }
}

?>
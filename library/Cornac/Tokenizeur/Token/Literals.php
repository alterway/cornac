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

class Cornac_Tokenizeur_Token_Literals extends Cornac_Tokenizeur_Token {
    protected $tname = 'literals';

    private $value = null;     // @note value of the literal
    private $delimiter = null; // @note delimter used. Used for string literals
    private $type = 'literals';
    
    function __construct($expression = null) {
        parent::__construct(array());
        
        if (count($expression) == 2) {
            $this->delimiter = trim(substr($expression[0]->getCode(), 3));
            $this->value = $expression[1]->getCode();
        } elseif (count($expression) == 3) {
            $this->value = $expression[1];
            if (strlen($this->value) > 0 && ($this->value[0] == '"' || $this->value[0] == "'")) {
                $this->delimiter = $this->value[0];
                $this->value = substr($this->value, 1, -1);
            }
        } else {
            // @note only 1 element
            $this->value = $expression[0]->getCode();
            if (strlen($this->value) > 0 && ($this->value[0] == '"' || $this->value[0] == "'")) {
                $this->delimiter = $this->value[0];
                $this->value = substr($this->value, 1, -1);
            }
        }
    }
    
    function getCode() {
        if (strlen($this->value) && ($this->value[0] == '"' || $this->value[0] == "'")) {
            $this->delimiter = $this->value[0];
            $this->value = substr($this->value, 1, -1);
        }
        return $this->value;
    }

    function neutralise() {
        // @note nothing to do
    }

    function __toString() {
        return $this->getTname()." ".$this->value;
    }

    function getLiteral() {
        return $this->value;
    }

    function getDelimiter() {
        return $this->delimiter;
    }

    static function getRegex() {
        return array('Cornac_Tokenizeur_Regex_Literals_Simple',
                     'Cornac_Tokenizeur_Regex_Literals_Heredoc',
                    );
    }
}

?>
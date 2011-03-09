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

class Cornac_Tokenizeur_Token_Ifthen extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = 'ifthen';
    protected $condition = array();
    protected $then = array();
    protected $else = null;
    

    function __construct($condition) {
        parent::__construct(array());
        
        while(count($condition) >= 2) {
            $this->condition[] = array_shift($condition);
            $this->then[]      = array_shift($condition);
        }
        if (count($condition) == 1) {
            $this->else = array_shift($condition);
        }
    }
    
    function add($condition, $then) {
        $this->condition[] = $condition;
        $this->then[] = $then;
    }

    function __toString() {
        return $this->getTname()." if (".$this->condition.") then ".$this->then." else ".$this->else;
    }

    function getCondition() {
        return $this->condition;
    }

    function getThen() {
        return $this->then;
    }

    function getElse() {
        return $this->else;
    }

    function getToken() {
        return 0;
    }

    function neutralise() {
        foreach($this->condition as &$condition) {
            $condition->detach();
        }
        foreach($this->then as &$then) {
            $then->detach();
        }
        if (!is_null($this->else)) {
            $this->else->detach();
        }
    }

    function getRegex() {
        return array(
    'Cornac_Tokenizeur_Regex_Ifthen_Block',
    'Cornac_Tokenizeur_Regex_Ifthen_Blockelseblock',
    'Cornac_Tokenizeur_Regex_Ifthen_Elsemultiples',
    'Cornac_Tokenizeur_Regex_Ifthen_Elsesimple',
    'Cornac_Tokenizeur_Regex_Ifthen_Elseifsimple',
    'Cornac_Tokenizeur_Regex_Ifthen_Elseifsequence',
    'Cornac_Tokenizeur_Regex_Ifthen_Elsesequence',
    'Cornac_Tokenizeur_Regex_Ifthen_Elseifalternative',
    'Cornac_Tokenizeur_Regex_Ifthen_Elsealternativeblock',
    'Cornac_Tokenizeur_Regex_Ifthen_Elsealternative',
    'Cornac_Tokenizeur_Regex_Ifthen_Elseempty',
    );

    }
}

?>
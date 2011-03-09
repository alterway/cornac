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

class Cornac_Tokenizeur_Token_Ternaryop extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = 'ternaryop';
    protected $condition = null;
    protected $then = null;
    protected $else = null;
    
    function __construct($expression) {
        parent::__construct(array());
        if (!is_array($expression)) {
        
        } elseif (count($expression) == 2) {
            if ($expression[0]->checkClass('arglist')) {
                $this->condition = $expression[0]->getList();
                $this->condition = $this->condition[0];
            } else {
                $this->condition = $expression[0];
            }
            $this->then     = null;
            $this->else      = $expression[1];
        } elseif (count($expression) == 3) {
            if ($expression[0]->checkClass('arglist')) {
                $this->condition = $expression[0]->getList();
                $this->condition = $this->condition[0];
            } else {
                $this->condition = $expression[0];
            }
            $this->then     = $expression[1];
            $this->else      = $expression[2];
        } else {
            $this->stopOnError("Wrong number of arguments  : '".count($expression)."' in ".__METHOD__);
        }
    }

    function __toString() {
        return $this->getTname()." ".$this->code;
    }

    static function getRegex() {
        return array('Cornac_Tokenizeur_Regex_Ternaryop');
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

    function neutralise() {
        $this->condition->detach();
        if (!is_null($this->then)) {
            $this->then->detach();
        }
        $this->else->detach();
    }
}
?>
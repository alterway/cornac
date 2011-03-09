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

class Cornac_Tokenizeur_Token_Logical extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = 'logical';
    protected $left = null;
    protected $operator = null;
    protected $right = null;
    
    function __construct($expression) {
        parent::__construct(array());
        
        if (is_array($expression)) {
            $this->left = $expression[0];
            $this->operator = $this->makeProcessed('_logical_', $expression[1]);
            $this->right = $expression[2];
        } else {
            $this->stopOnError("Must receive an array as argument : ".count($expression)." received\n");
        }
    }

    function __toString() {
        return $this->getTname()." ".$this->left." ".$this->operator." ".$this->right;
    }

    function getLeft() {
        return $this->left;
    }

    function getOperator() {
        return $this->operator;
    }

    function getRight() {
        return $this->right;
    }

    function neutralise() {
       $this->right->detach();
       $this->operator->detach();
       $this->left->detach();
    }

    static function getRegex() {
        return array('Cornac_Tokenizeur_Regex_Logical');
    }
}

?>
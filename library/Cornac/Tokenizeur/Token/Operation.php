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

class Cornac_Tokenizeur_Token_Operation extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = 'operation';
    protected $left = null;
    protected $operation = null;
    protected $right = null;
    
    function __construct($expression) {
        parent::__construct(array());
        
        if (count($expression) == 3) {
            $this->left = $expression[0];
            $this->operation = $this->makeProcessed('_operation_', $expression[1]);
            $this->right = $expression[2];
        } else {
            $this->stopOnError("We shouldn't reach here");
        }
    }

    function __toString() {
        return $this->getTname()." ".$this->left." ".$this->operation." ".$this->right;
    }

    function getRight() {
        return $this->right;
    }

    function getOperation() {
        return $this->operation;
    }

    function getLeft() {
        return $this->left;
    }

    function neutralise() {
       $this->left->detach();
       $this->operation->detach();
       $this->right->detach();
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Operation_Multiplication',
                     'Cornac_Tokenizeur_Regex_Operation_Addition');
    }
}

?>
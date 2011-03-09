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

class Cornac_Tokenizeur_Token_Variable extends Cornac_Tokenizeur_Token {
    protected $tname = 'variable';
    protected $name = null;

    function __construct($expression = null) {
        parent::__construct(array());

        if (is_null($expression)) { // @note  coming from class _array
            return ;
        }

        if (count($expression) == 1) {
            if ($expression[0]->checkClass(array('variable','Token'))) {
                $this->name = $expression[0]->getCode();
            } else {
                $this->name = $expression[0];
            }
            $this->setLine($expression[0]->getLine());
        } elseif (count($expression) == 3) {
            // @doc coming from token
            $this->name = $expression[1];
        } else {
          $this->name = $expression[1];
          $this->code = $this->name->getCode();
          $this->setLine($this->name->getLine());
        }
    }

    function __toString() {
        return $this->getTname()." ".$this->name;
    }
    
    function getName() {
        return $this->name;
    }
    
    function neutralise() {
        if (is_object($this->name)) {
            $this->name->detach();
        }
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Variable_Simple',
                     'Cornac_Tokenizeur_Regex_Variable_Separatedcurly',
                     'Cornac_Tokenizeur_Regex_Variable_Curly',
                     'Cornac_Tokenizeur_Regex_Variable_Variable',
                     );
    }
}

?>
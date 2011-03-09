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

class Cornac_Tokenizeur_Token_Functioncall extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = 'functioncall';
    protected $function = null;
    protected $args = null;
    
    function __construct($expression) {
        parent::__construct(array());
        
        if ($expression[0]->checkOperator('=')) {
            $expression[0]->code = 'echo';
        }
        
        if ($expression[0]->checkClass('Token')) {
            $this->function = $this->makeProcessed('_functionname_', $expression[0]);
        } else {
            $this->function = $expression[0];
        }

        if (isset($expression[1])) {
            $this->args = $expression[1];
        } else {
            $this->args = new Cornac_Tokenizeur_Token_Arglist(array( null ));
            $this->args->setLine($expression[0]->getLine());
        }
    }

    function __toString() {
        return $this->getTname()." ".$this->function." ( ".$this->args. " ) ";
    }

    function getFunction() {
        return $this->function;
    }

    function getArgs() {
        return $this->args;
    }

    function neutralise() {
        $this->function->detach();
        $this->args->detach();

        $this->setCode($this->function->getCode());
    }
    
   function getRegex() {
        return array(
    'Cornac_Tokenizeur_Regex_Functioncall_Simple',
    'Cornac_Tokenizeur_Regex_Functioncall_Echowithoutparenthesis',
    'Cornac_Tokenizeur_Regex_Functioncall_Withoutparenthesis',
    'Cornac_Tokenizeur_Regex_Functioncall_Withoutarglist',
    'Cornac_Tokenizeur_Regex_Functioncall_Variable',
    'Cornac_Tokenizeur_Regex_Functioncall_Variableempty',
    'Cornac_Tokenizeur_Regex_Functioncall_List',
    'Cornac_Tokenizeur_Regex_Functioncall_Shorttag',
                    );
    }    
}

?>
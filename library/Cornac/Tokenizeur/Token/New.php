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

class Cornac_Tokenizeur_Token_New extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = '_new';
    protected $class = null;
    protected $expression = null;
    
    function __construct($expression) {
        parent::__construct(array());
        
        $constructor = $expression[0];
        if ($constructor->checkClass('functioncall')) {
            $this->class = $constructor->getFunction();
            $this->args = $constructor->getargs();
        } elseif ($constructor->checkClass('method')) {
            $this->class = $constructor;
            if (!isset($expression[1])) {
                $this->args = new Cornac_Tokenizeur_Token_Arglist();
            } else {
                $this->args = $expression[1];
            }
        } elseif ($constructor->checkClass('_constant')) {
            $this->class =  new Cornac_Tokenizeur_Token_Processed_Classname($constructor->getName());
            if (!isset($expression[1])) {
                $this->args = new Cornac_Tokenizeur_Token_Arglist();
            } else {
                $this->args = $expression[1];
            }
        } elseif ($constructor->checkClass(array('variable','_array','property','property_static','method_static','_nsname'))) {
            $this->class = $constructor;

            if (!isset($expression[1])) {
                $this->args = new Cornac_Tokenizeur_Token_Arglist();
            } else {
                $this->args = $expression[1];
            }
        } elseif ($constructor->checkToken(T_STATIC) ) {
            $this->class = $this->makeProcessed('_static_', $constructor);

            if (!isset($expression[1])) {
                $this->args = new Cornac_Tokenizeur_Token_Arglist();
            } else {
                $this->args = $expression[1];
            }
        } else {
            $this->stopOnError("Unexpected class received : '".get_class($constructor)."' in ".__METHOD__);
        }
    }

    function __toString() {
        return $this->tname." ".$this->expression;
    }

    function getClass() {
        return $this->class;
    }

    function getArgs() {
        return $this->args;
    }

    function neutralise() {
        $this->class->detach();
        $this->args->detach();
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_New_Simple',
                     'Cornac_Tokenizeur_Regex_New_Single',
                     'Cornac_Tokenizeur_Regex_New_Variable',
                    );
    }

}

?>
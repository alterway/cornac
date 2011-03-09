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

class Cornac_Tokenizeur_Token_Declare extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = '_declare';
    protected $ticks = null;
    protected $encoding = null;
    protected $block = null;
    
    function __construct($expression) {
        parent::__construct(array());
        
        if ($expression[count($expression) - 1]->checkClass('block')) {
            $this->block = array_pop($expression);
        } else {
            // @empty_else
        }

        if ($expression[0]->checkClass('parenthesis')) {
            // @doc we expect no initialisation 
            if (!$this->set(strtolower($expression[0]->getContenu()->getLeft()->getCode()), 
                            $expression[0]->getContenu()->getRight())) {
                $this->stopOnError($expression[0]->getContenu()->getLeft()." is unknown in ".__METHOD__."\n");
            }
        } elseif ($expression[0]->checkClass('affectation')) {
            // @doc we expect an initialisation 
            if (!$this->set(strtolower($expression[0]->getLeft()->getCode()), 
                            $expression[0]->getRight())) {
                $this->stopOnError($expression[0]->getLeft()." is unknown in ".__METHOD__."\n");
            }
            if (!$this->set(strtolower($expression[1]->getLeft()->getCode()), 
                            $expression[1]->getRight())) {
                stopOnError($expression[1]->getLeft()." is unknown in ".__METHOD__."\n");
            }
        } else {
            $this->stopOnError("Entree is of unexpected class ".get_class($expression[0])." in ".__METHOD__."\n");
        }
    }
    
    function set($name, $value) {
        if (in_array($name, array('ticks','encoding'))) {
            $this->$name = $value;
            return true;
        }
        return false;
    }

    function __toString() {
        $string = $this->getTname()." ticks= ".$this->tick." encoding = ".$this->encoding;
        if (!is_null($this->block)) { $string .= " ".$this->block;}
        return $string; 
    }

    function getTicks() {
        return $this->ticks;
    }

    function getEncoding() {
        return $this->encoding;
    }

    function getBlock() {
        return $this->block;
    }

    function neutralise() {
        if (!is_null($this->ticks)) {
            $this->ticks->detach();
        }
        if (!is_null($this->encoding)) {
            $this->encoding->detach();
        }
        if (!is_null($this->block)) {
            $this->block->detach();
        }
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Declare_Simple',
                     'Cornac_Tokenizeur_Regex_Declare_Alternative',
                    );
    }

}

?>
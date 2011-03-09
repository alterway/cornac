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

class Cornac_Tokenizeur_Token_Interface extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = '_interface';
    protected $name = null;
    protected $block = null;
    protected $extends = array();
    
    function __construct($expression = null) {
        parent::__construct(array());
        
        $this->name = $this->makeProcessed('_interfacename_',$expression[0]);
        unset($expression[0]);
        $this->block = array_pop($expression);
        
        foreach($expression as $e) {
            $this->extends[] = $this->makeProcessed('_extends_', $e);
        }
    }

    function __toString() {
        $return = $this->getTname()." interface {$this->name} ";
        if (count($this->extends) > 0) {
            $return .= " extends ".join(', ', $this->extends);
        }
        $return .= "{ ".$this->block." } ";
        
        return $return;
    }

    function getBlock() {
        return $this->block;
    }

    function getName() {
        return $this->name;
    }

    function getExtends() {
        return $this->extends;
    }

    function neutralise() {
        $this->block->detach();
        $this->name->detach();
        foreach($this->extends as $e) {
            $e->detach();
        }
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Interface',
                    );
    }

}

?>
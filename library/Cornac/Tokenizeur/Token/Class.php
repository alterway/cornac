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

class Cornac_Tokenizeur_Token_Class extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = '_class';
    protected $_abstract = null;
    protected $name = array();
    protected $extends = null;
    protected $implements = array();
    protected $block = null;
    

    function __construct($expression) {
        parent::__construct(array());

        $pos = 0;
        if ($expression[$pos]->checkToken(T_ABSTRACT)) {
            $this->_abstract = $this->makeProcessed('_abstract_',$expression[$pos]);
            $pos += 1;
        } elseif ($expression[$pos]->checkToken(T_FINAL)) {
            $this->_abstract = $this->makeProcessed('_final_',$expression[$pos]);
            $pos += 1;
        }

        $this->name = $this->makeProcessed('_classname_',$expression[$pos]);
        $pos ++;
        
        if ($expression[$pos]->checkToken(T_EXTENDS)) {
            $this->extends = $this->makeProcessed('_extends_',$expression[$pos + 1]);
            $pos += 2;
        }

        if ($expression[$pos]->checkToken(T_IMPLEMENTS)) {
            $this->implements[] = $this->makeProcessed('_implements_',$expression[$pos + 1]);
            $pos += 2;
            
            while ($expression[$pos]->checkCode(',')) {
                $this->implements[] = $this->makeProcessed('_implements_',$expression[$pos + 1]);
                $pos += 2;
            }
        }
        $this->block = $expression[$pos];
    }
    
    function __toString() {
        $return = $this->getTname()." class ".$this->name;
        if (!is_null($this->extends)) {
            $return .= " extends ".$this->extends;
        }
        if (count($this->implements) > 0) {
            $return .= " implements ".join(', ', $this->implements);
        }
        $return .= " {".$this->block."} ";

        return $return;
    }

    function getName() {
        return $this->name;
    }

    function getAbstract() {
        return $this->_abstract;
    }

    function getExtends() {
        return $this->extends;
    }

    function getImplements() {
        return $this->implements;
    }

    function getBlock() {
        return $this->block;
    }

    function neutralise() {
        $this->name->detach();
        if (count($this->implements) > 0) {
            foreach($this->implements as $e) {
                $e->detach();
            }
        }
        if (!is_null($this->extends)) {
            $this->extends->detach();
        }
        if (!is_null($this->_abstract)) {
            $this->_abstract->detach();
        }
        $this->block->detach();
    }

    function getRegex() {
        return array( 'Cornac_Tokenizeur_Regex_Class',
                    );
    }
}

?>
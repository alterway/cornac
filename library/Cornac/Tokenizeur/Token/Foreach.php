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

class Cornac_Tokenizeur_Token_Foreach extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = '_foreach';
    protected $array = array();
    protected $key = null;
    protected $value = null;
    protected $block = null;
    
    static $incoming_vars = array('variable','_array','property', 'property_static',
                                  'functioncall','method','cast','method_static','_new',
                                  'affectation','ternaryop','parenthesis','noscream',
                                  'inclusion','Token','operation');

    static $blind_values = array('variable','_array','property','reference','parenthesis','property_static');
    static $blind_keys = array('variable','_array','property','reference','parenthesis','property_static');

    function __construct($expression) {
        parent::__construct(array());
            
        $block = array_pop($expression);
        if ($block->checkCode(';')) {
            $real = new Cornac_Tokenizeur_Token_Block(array());
            $real->replace($block);
            
            $expression[] = $real;
            $expression = array_values($expression);
        } else {
            $expression[] = $block;
            $expression = array_values($expression);
        }
        
        if (count($expression) == 4) {
            if ($expression[0]->checkClass('Token')) {
                $this->array = $this->makeProcessed('_foreacharray_', $expression[0]);
            } else {
                $this->array = $expression[0];
            }
            $this->key = $expression[1];
            $this->value = $expression[2];
            $this->block = $expression[3];
        } else {
            if ($expression[0]->checkClass('Token')) {
                $this->array = $this->makeProcessed('_foreacharray_', $expression[0]);
            } else {
                $this->array = $expression[0];
            }
            $this->key =  null;
            $this->value = $expression[1];
            $this->block = $expression[2];
        }    
    }
    
    function __toString() {
        return $this->getTname()." foreach (".$this->array.") { ".$this->block." } ";
    }

    function getArray() {
        return $this->array;
    }

    function getKey() {
        return $this->key;
    }

    function getValue() {
        return $this->value;
    }

    function getBlock() {
        return $this->block;
    }

    function neutralise() {
        $this->array->detach();
        if (!is_null($this->key)) { 
            $this->key->detach();
        }
        $this->value->detach();
        $this->block->detach();
    }

    function getRegex() {
        return array(
    'Cornac_Tokenizeur_Regex_Foreach_Simple',
    'Cornac_Tokenizeur_Regex_Foreach_Withkey',
    'Cornac_Tokenizeur_Regex_Foreach_Alternative',
);
    }
}

?>
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

class Cornac_Tokenizeur_Token_Concatenation extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = 'concatenation';
    protected $list = array();
    
    function __construct($list) {
        parent::__construct(array());
        
        foreach($list as $l) {
            if ($l->checkClass('concatenation')) {
                $this->list = array_merge($this->list, $l->getList());
            } elseif ($l->checkClass('sequence')) {
                $this->list = array_merge($this->list, $l->getElements());
            } elseif ($l->checkClass('block')) {
                $this->list = array_merge($this->list, $l->getList());
            } else {
                $this->list[] = $l;
            }
         }
    }

    function __toString() {
        $return = $this->getTname()." ";
        
        foreach($this->list as $a) {
            $return .= $a." . ";
        }
        $return = substr($return, 0, -2)." ";
        return $return;
    }

    function getList() {
        return $this->list;
    }

    function neutralise() {
        foreach($this->list as $id => $a) {
            $a->detach();
        }
    }

   function getRegex() {
        return array(
        'Cornac_Tokenizeur_Regex_Concatenation_Simple',
        'Cornac_Tokenizeur_Regex_Concatenation_Interpoled');
    }    
}

?>
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

class Cornac_Tokenizeur_Token_Arglist extends Cornac_Tokenizeur_Token {
    protected $tname = 'arglist';

    protected $list = array();
    
    function __construct($expression = array()) {
        parent::__construct(array());
        
        foreach($expression as $l) {  
            if (is_null($l)) {
                $this->list[] = $l;
            } elseif ($l->checkOperator(',')) {
                $this->list[] = new Cornac_Tokenizeur_Token_Processed_Empty('[empty]');
            } else {
                $this->list[] = $l;
            }
        }
        if (isset($this->expression[0])) {
            $this->setLine($this->list[0]->getLine());
        }
    }

    function __toString() {
        $return = $this->getTname()."(";
        
        if (count($this->list) > 0) {
            foreach($this->list as $a) {
                $return .= $a.", ";
            }
            $return = substr($return, 0, -2).")";
        } else {
            $return = "( )";
        }
        return $return;
    }

    function getList() {
        return $this->list;
    }

    function neutralise() {
        if (!is_array($this->list)) { return null; }

        foreach($this->list as $id => &$a) {
            if (!is_null($a)) {
                $a->detach();
            }
        }
    }
    
   function getRegex() {
        return array('Cornac_Tokenizeur_Regex_Arglist');
    }
    
}

?>
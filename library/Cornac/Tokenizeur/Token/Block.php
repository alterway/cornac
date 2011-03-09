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

class Cornac_Tokenizeur_Token_Block extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = 'block';
    protected $list = array();
    
    function __construct($expression = array()) {
        parent::__construct(array());
        
        if (is_null($expression)) {
            $expression = array();
        }

        foreach($expression as $l) {
            if ($l->checkClass('sequence')) {
                $this->list = array_merge($this->list, $l->getElements());
            } elseif ($l->checkClass('block')) {
                $this->list = array_merge($this->list, $l->getList());
            } else {
                $this->list[] = $l;
            }
         }
         if (isset($this->list[0])) {
             $this->setLine($this->list[0]->getLine());
         }
    }

    function __toString() {
        return $this->getTname()." {".join("\n", $this->list)." }";
    }

    function getList() {
        return $this->list;
    }

    function getToken() {
        return 0;
    }

    function getCode() {
        return '';
    }

    function neutralise() {
        foreach($this->list as $e) {
            $e->detach();
        }
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Block_Simple',
                     'Cornac_Tokenizeur_Regex_Block_Casedefault',
                    );
    }
}

?>
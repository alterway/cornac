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

class Cornac_Tokenizeur_Token_Constant extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = '_constant';
    
    function __construct() {
        parent::__construct(array());
        
    }

    function __toString() {
        return $this->getTname()." ".$this->code;
    }

    function getName() {
        return $this->code;
    }

    function neutralise() {
    // @doc nothing to neutralize
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Constant_Normal',
                     'Cornac_Tokenizeur_Regex_Constant_Magical',
                    );
    }
    
}

?>
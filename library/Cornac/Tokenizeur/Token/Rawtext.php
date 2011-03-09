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

class Cornac_Tokenizeur_Token_Rawtext extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = 'rawtext';
    protected $rawtext = null;

    function __construct($expression = null) {
        parent::__construct(array());
        
        if ($expression[0]->checkToken(T_CLOSE_TAG)) {
            $this->rawtext = $expression[0];
            
            $this->rawtext->setToken(T_INLINE_HTML);
            $this->rawtext->setCode('');
        } else {
            $this->rawtext = $expression[0];
        }
    }

    function __toString() {
        return $this->getTname()." ".$this->rawtext;
    }
    
    function getText() {
        return $this->rawtext;
    }

    function neutralise() {
        $this->rawtext->detach();
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Rawtext_Simple',
                     'Cornac_Tokenizeur_Regex_Rawtext_Empty',
                     );
    }

}

?>
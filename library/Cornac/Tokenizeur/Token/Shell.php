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

class Cornac_Tokenizeur_Token_Shell extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = 'shell';
    protected $expression = array();
    
    function __construct($expression) {
        parent::__construct(array());
        
        foreach($expression as $e) {
            if ($e->checkClass('sequence')) {
                $this->expression = array_merge($this->expression, $e->getElements());
            } else {
                // @todo accept anything?
                $this->expression[] = $e;
            }
        }
    }

    function __toString() {
        return $this->getTname()." `".$this->code."`";
    }

    function getExpression() {
        return $this->expression;
    }

    function neutralise() {
        foreach($this->expression as $e) {
            $e->detach();
        }
    }

    static function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Shell'
                    );
    }

}

?>
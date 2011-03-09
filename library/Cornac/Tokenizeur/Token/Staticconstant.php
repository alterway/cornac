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

class Cornac_Tokenizeur_Token_Staticconstant extends Cornac_Tokenizeur_Token {
    protected $tname = 'constant_static';
    protected $class = null;
    protected $constant = null;
    
    function __construct($expression) {
        parent::__construct();
        
        if (is_array($expression)) {
            if ($expression[0]->checkClass('Token')) {
                $this->class = $this->makeProcessed('_classname_', $expression[0]);
            } else {
                $this->class = $expression[0];
            }
            $this->constant = $expression[1];
        } else {
            $this->stopOnError("Wrong number of arguments  : '".count($expression)."' in ".__METHOD__);
        }
    }

    function getClass() {  
        return $this->class;
    }

    function getConstant() {
        return $this->constant;
    }

    function neutralise() {
        $this->class->detach();
        $this->constant->detach();
    }

    function __toString() {
        return $this->getTname()." ".$this->class."::".$this->constant;
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Staticconstant',
                     );
    }

}

?>
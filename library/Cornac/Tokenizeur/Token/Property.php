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

class Cornac_Tokenizeur_Token_Property extends Cornac_Tokenizeur_Token { 
    protected $tname = 'property';
    private $object = null;
    private $property = null;

    function __construct($expression) {
        parent::__construct();
        
        if (is_array($expression) && count($expression) == 2) {
            $this->object = $expression[0];
            
            $this->property = $expression[1];
        } else {
            $this->stopOnError("Bad number of parameters in ".__METHOD__);
        }
    }

    function getObject() {  
        return $this->object;
    }

    function getProperty() {
        return $this->property;
    }

    function neutralise() {
        $this->object->detach();
        $this->property->detach();
    }

    function __toString() {
        return $this->getTname()." ".$this->object."->".$this->property;
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Property_Simple',
                     'Cornac_Tokenizeur_Regex_Property_Curly',
                     );
    }

    function getCode(){
        return '';
    }

}

?>
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

class Cornac_Tokenizeur_Token_Method extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = 'method';
    private $object = null;
    private $method = null;
    
    function __construct($in) {
        parent::__construct(array());
        
        if (is_array($in)) {
            $this->object = $in[0];
            $this->method = $in[1];
        } else {
            $this->stopOnError( 'Wrong type of argument');
        }
    }

    function getObject() {  
        return $this->object;
    }

    function getMethod() {
        return $this->method;
    }

    function neutralise() {
        $this->object->detach();
        $this->method->detach();
    }

    function __toString() {
        return $this->getTname()." ".$this->object."->".$this->method;
    }

    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Method_Simple',
                     'Cornac_Tokenizeur_Regex_Method_Curly',
                     );
    }

}

?>
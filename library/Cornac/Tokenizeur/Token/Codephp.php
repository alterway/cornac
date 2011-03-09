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

class Cornac_Tokenizeur_Token_Codephp extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = 'codephp';
    private $php_code = array();
    
    function __construct($expression = null) {
        parent::__construct(array());

        if (is_null($expression) || empty($expression)) {
            $this->php_code = new Cornac_Tokenizeur_Token_Sequence(array());
        } else {
            $this->php_code =  $expression[0];
            if (count($expression) > 1) {
                $this->stopOnError("We lost some elements in ".__METHOD__);
            }
        }
    }

    function neutralise() {
        $this->php_code->detach();
    }

    function getphp_code() {
        return $this->php_code;
    }
    
    function getRegex(){
        return array('Cornac_Tokenizeur_Regex_Codephp_Empty', 
                     'Cornac_Tokenizeur_Regex_Codephp_Unfinished', 
                     'Cornac_Tokenizeur_Regex_Codephp_Unfinishedempty', 
                     'Cornac_Tokenizeur_Regex_Codephp_Simple',
                     'Cornac_Tokenizeur_Regex_Codephp_Withsemicolon',
                     'Cornac_Tokenizeur_Regex_Codephp_Unfinishedwithsemicolon',
                     'Cornac_Tokenizeur_Regex_Codephp_Emptysequence',
                    );
    }
}

?>
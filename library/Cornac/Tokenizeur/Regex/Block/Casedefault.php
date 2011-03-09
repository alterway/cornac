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

class Cornac_Tokenizeur_Regex_Block_Casedefault extends Cornac_Tokenizeur_Regex {
    protected $tname = 'block_casedefault_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array('{');
    }
    
    function check($t) {
        if (!$t->hasNext())           { return false; }

        $this->remove[] = 0;
        
        $var = $t->getNext();            
        $i = 1;

        if($var->checkOperator(';')) {
        // @note one ; is accepted after switch
           $var = $var->getNext();
           $this->remove[] = $i;
           $i++;
        }

        while($var->checkNotOperator('}')) {
            if ($var->checkClass(array('_case','_default'))) {
                $this->args[] = $i;
                $this->remove[] = $i;
                
                if (!$var->hasNext()) { 
                    return false; 
                }
                $var = $var->getNext();
                $i++;
                continue;
            }

            if ($var->checkCode('{') ) {
                // @doc nested blocks? aborting.
                $this->args = array();
                $this->remove = array();
                return false;
            }

            // @doc Can't be processed? Just abort
            $this->args = array();
            $this->remove = array();
            return false;
        }

        
        $this->remove[] = $i ; // @note removeing final }

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true;
    }
}
?>
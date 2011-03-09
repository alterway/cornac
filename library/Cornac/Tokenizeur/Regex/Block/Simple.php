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

class Cornac_Tokenizeur_Regex_Block_Simple extends Cornac_Tokenizeur_Regex {
    protected $tname = 'block_normal_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array('{');
    }
    
    function check($t) {
        if ($t->hasPrev() && $t->getPrev()->checkOperator(array('->',']','}')))   { return false; }
        if ($t->hasPrev() && $t->getPrev()->checkClass(array('property','variable','property_static','_array')))  { return false; }
        if ($t->checkClass('block') ) { return false; }
        if (!$t->hasNext())           { return false; }

        $this->remove[] = 0;
        
        $var = $t->getNext();            
        $i = 1;

        while($var->checkNotOperator('}')) {
            if ($var->checkForBlock(true)) {
                $this->args[] = $i;
                $this->remove[] = $i;
                if (!$var->hasNext()) { return $t; }
                $var = $var->getNext();
                $i++;
                continue;
            }

            if ($var->checkNotClass(array('block','Token')) && 
                $var->getNext()->checkOperator(';')) {
                $this->args[] = $i;

                $this->remove[] = $i;
                $this->remove[] = $i + 1;
                if (!$var->hasNext(1)) { return $t; }
                $var = $var->getNext(1);
                $i += 2;
                continue;
            }

            if ($var->checkOperator('{') ) {
                // @doc nested blocks? aborting
                $this->args = array();
                $this->remove = array();
                return false;
            }

            if ($var->checkOperator(';') ) {
                // @doc one forgotten semi-colon? ignore it.
                $this->remove[] = $i;
                $i++;
                if (!$var->hasNext()) { 
                    return $t; 
                }
                $var = $var->getNext();
                continue;
            }

            // @doc not understood? Sorry...
            $this->args = array();
            $this->remove = array();
            return false;
        }
        
        $this->remove[] = $i ; // @note Removing final }
        
        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true;
    }
}
?>
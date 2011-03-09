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

class Cornac_Tokenizeur_Regex_Function_Typehint extends Cornac_Tokenizeur_Regex {
    protected $tname = 'function_typehint_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_FUNCTION);
    }
    
    function check($t) {
        if (!$t->hasNext(3)) { return false; }
        
        // @doc this is function x() {} . 
        // @doc speed optimisation
        if ($t->getNext(1)->checkClass('arglist')) { return false; }

        $var = $t->getNext(2);

        while ($var->checkNotOperator(')')) {

            if (!$var->hasNext()) { return false; }
            if ($var->checkNotClass('_constant') &&
                 $var->checkNotToken(array(T_ARRAY,T_STRING))){ return false; }
            if ($var->getNext()->checkNotClass('variable')) { return false; }
                
                if ($var->getNext(1)->checkOperator('=') &&
                    $var->getNext(2)->checkNotClass('Token')) {
                        $regex = new Cornac_Tokenizeur_Regex_Model('affectation',array(0, 1, 2), array(1, 2));
                        Cornac_Tokenizeur_Token::applyRegex($var->getNext(), 'affectation', $regex);

                        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => affectation (".$this->getTname().")");

                        $regex = new Cornac_Tokenizeur_Regex_Model('typehint',array(0, 1), array(1));
                        Cornac_Tokenizeur_Token::applyRegex($var, 'typehint', $regex);

                        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => typehint (".$this->getTname().")");

                        $var = $var->getNext();
                        continue; 
                } elseif ($var->getNext(1)->checkOperator('=')) {
                    if ($var->getNext(2)->checkClass('Token')) { return false; }
                    if ($var->getNext(3)->checkClass('arglist')) {
                        $regex = new Cornac_Tokenizeur_Regex_Model('functioncall',array(0, 1), array(1));
                        Cornac_Tokenizeur_Token::applyRegex($var->getNext(2), 'functioncall', $regex);

                        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => affectation (".$this->getTname().")");
                        // @note return? 
                    }
                    
                    $regex = new Cornac_Tokenizeur_Regex_Model('affectation',array(0, 1, 2), array(1, 2));
                    Cornac_Tokenizeur_Token::applyRegex($var->getNext(), 'affectation', $regex);

                    Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => affectation (".$this->getTname().")");

                    $regex = new Cornac_Tokenizeur_Regex_Model('typehint',array(0, 1), array(1));
                    Cornac_Tokenizeur_Token::applyRegex($var, 'typehint', $regex);
    
                    Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => typehint = (".$this->getTname().")");
                    
                    $var = $var->getNext();
                    continue; 
                } elseif ($var->getNext(1)->checkOperator(array(',',')'))) {
                    $regex = new Cornac_Tokenizeur_Regex_Model('typehint',array(0, 1), array(1));
                    Cornac_Tokenizeur_Token::applyRegex($var, 'typehint', $regex);
    
                    Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => typehint ,) (".$this->getTname().")");
                    
                    $var = $var->getNext();
                    continue; 
                } 

            // @note typehint with initialisation
            if ($var->checkOperator('(')) {
                // @note avoiding collision with other structures
                return false; 
            }
            
            if (!$var->hasNext()) { return false; }
            $var = $var->getNext();
        }

        return false;
    }
}

?>
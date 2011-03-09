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

class Cornac_Tokenizeur_Regex_Function_Typehintreference extends Cornac_Tokenizeur_Regex {
    protected $tname = 'function_typehintreference_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_FUNCTION);
    }
    
    function check($t) {
        if (!$t->hasNext(3)) { return false; }

        $var = $t->getNext(2);
        
        while ($var->checkNotOperator(')')) {
            if (($var->checkClass('_constant') ||
                 $var->checkToken(T_ARRAY)) &&
                $var->getNext()->checkOperator('&') &&
                $var->getNext(1)->checkClass('variable')) {
                
                if ($var->getNext(2)->checkOperator('=') &&
                    $var->getNext(3)->checkNotClass('Token')) {
                          
                        $regex = new Cornac_Tokenizeur_Regex_Model('reference',array(1), array(1));
                        Cornac_Tokenizeur_Token::applyRegex($var->getNext(), 'reference', $regex);
    
                        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => reference 1 (".$this->getTname().")");

                        $regex = new Cornac_Tokenizeur_Regex_Model('affectation',array(0, 1, 2), array(1, 2));
                        Cornac_Tokenizeur_Token::applyRegex($var->getNext(), 'affectation', $regex);
    
                        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => affectation (".$this->getTname().")");

                        $regex = new Cornac_Tokenizeur_Regex_Model('typehint',array(0, 1), array(1));
                        Cornac_Tokenizeur_Token::applyRegex($var, 'typehint', $regex);
    
                        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => typehint = (".$this->getTname().")");

                        $var = $var->getNext();
                        if (is_null($var)) { return false; }
                        continue; 
                } elseif ($var->getNext(2)->checkNotCode('=')) {
                    $regex = new Cornac_Tokenizeur_Regex_Model('reference',array(1), array(1));
                    Cornac_Tokenizeur_Token::applyRegex($var->getNext(), 'reference', $regex);
    
                    Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => reference 2 (".$this->getTname().")");                    
                    
                    $regex = new Cornac_Tokenizeur_Regex_Model('typehint',array(0, 1), array(1));
                    Cornac_Tokenizeur_Token::applyRegex($var, 'typehint', $regex);
    
                    Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => typehint init =2 (".$this->getTname().")");
                    
                    $var = $var->getNext();
                    if (is_null($var)) { return false; }
                    continue; 
                } elseif ($var->getNext(2)->checkOperator(array(',',')'))) {
                    $regex = new Cornac_Tokenizeur_Regex_Model('reference',array(1), array(1));
                    Cornac_Tokenizeur_Token::applyRegex($var->getNext(), 'reference', $regex);
    
                    Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => reference 3 (".$this->getTname().")");

                    $regex = new Cornac_Tokenizeur_Regex_Model('typehint',array(0, 1), array(1));
                    Cornac_Tokenizeur_Token::applyRegex($var, 'typehint', $regex);
    
                    Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => typehint =3 (".$this->getTname().")");
                    
                    $var = $var->getNext();
                    if (is_null($var)) { return false; }
                    continue; 
                } 
            }
            // @note case of typehint with initialisation
            
            if ($var->checkOperator('(')) {
                // @note typehing can't be followed by an opening bracket
                return false; 
            }
            
            // @note there must be something beyond...
            if (!$var->hasNext()) { return false; }
            $var = $var->getNext();
            if (is_null($var)) { return false; }
        }

        return false;
    }
}

?>
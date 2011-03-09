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

class Cornac_Tokenizeur_Regex_Classconstant extends Cornac_Tokenizeur_Regex {
    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_CONST);
    }
    
    function check($t) {
        if (!$t->hasNext(1) ) { return false; }

        if ($t->getNext()->checkNotClass('affectation')) { return false; }

        $var = $t->getNext(1);
        while($var->checkOperator(',')) {
            if ($var->getNext()->checkNotClass('affectation')) { return false; }
            $var = $var->getNext(1);
        }
        
        if ($var->checkNotOperator(';') &&
            $var->checkNotToken(T_CLOSE_TAG) &&
            $var->checkNotClass('rawtext')) {
            return false;
        }
        
        $var = $t;

        while($var->checkOperator(',') || $var->checkToken(T_CONST)) {
        // @note registering a new constante each comma
            $args = array(1);
            $remove = array(1);

            // @note $var is changed before $repl is replaced
            $repl = $var;
            $var = $var->getNext(1);

            $regex = new Cornac_Tokenizeur_Regex_Model('Cornac_Tokenizeur_Token_Classconstant',$args, $remove);
            Cornac_Tokenizeur_Token::applyRegex($repl, 'Cornac_Tokenizeur_Token_Classconstant', $regex);

            Cornac_Log::getInstance('tokenizer')->log(get_class($var)." => constant_class  (".$this->getTname().")");
            continue;
        }
        
        return false; 
    }
}
?>
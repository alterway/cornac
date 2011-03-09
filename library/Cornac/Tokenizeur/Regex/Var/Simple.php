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

class Cornac_Tokenizeur_Regex_Var_Simple extends Cornac_Tokenizeur_Regex {
    protected $tname = 'var_simple_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_VAR, T_PRIVATE, T_PROTECTED, T_PUBLIC);
    }
    
    function check($t) {
        if (!$t->hasNext(1)) { return false; }

        $this->args = array(0, 1);
        $this->remove = array(1);

        if ($t->hasPrev() &&
            $t->getPrev()->checkToken(array(T_STATIC))) { 

            $this->args[] = -1;
            $this->remove[] = -1;

            sort($this->args);
            sort($this->remove);
        }

        if ($t->getNext()->checkToken(array(T_STATIC))) { 
            $var = $t->getNext(2);
        } else {
            $var = $t->getNext(1);
        }

        if ($var->getPrev()->checkNotClass(array('variable','affectation'))) { return false; }

        while($var->checkOperator(',')) {
            if ($var->getNext()->checkNotClass(array('variable','affectation'))) { return false; }
            $var = $var->getNext(1);
        }
        
        if ($var->checkNotOperator(';') &&
            $var->checkNotToken(T_CLOSE_TAG) &&
            $var->checkNotClass('rawtext')) {
            return false;
        }

// @todo static est abandonné!
        if ($t->getNext()->checkToken(array(T_STATIC))) { 
            $var = $t->getNext();
            $token_bis = $t->getToken() + T_STATIC;
        } elseif ($t->getPrev()->checkToken(array(T_STATIC))) { 
            $var = $t;
            $token_bis = $t->getToken() + T_STATIC;
        } else {
            $var = $t;
            $token_bis = $t->getToken();
        }

        while($var->checkOperator(',') || $var->checkToken(array(T_VAR, T_PRIVATE, T_PROTECTED, T_PUBLIC, T_STATIC))) {
                // @note registering a new global each comma
                    $args = array(0, 1);
                    $remove = array(1);
                    if ($var->getPrev()->checkToken(array(T_VAR, T_PRIVATE, T_PROTECTED, T_PUBLIC, T_STATIC))) {
                        $remove[] = -1;
                        sort($remove);
                    }

                    $repl = $var;
                    $repl->setToken($token_bis);
                    $var = $var->getNext(1);

                    $regex = new Cornac_Tokenizeur_Regex_Model('Cornac_Tokenizeur_Token_Var', $args, $remove);
                    Cornac_Tokenizeur_Token::applyRegex($repl, 'Cornac_Tokenizeur_Token_Var', $regex);

                    Cornac_Log::getInstance('tokenizer')->log(get_class($var)." => _var  (".$this->getTname().")");
                    continue;
        }

        return false;
    }
}

?>
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

class Cornac_Tokenizeur_Regex_Global extends Cornac_Tokenizeur_Regex {
    protected $tname = 'global_simple_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_GLOBAL);
    }
    
    function check($t) {
        if (!$t->hasNext(1)) { return false; }

        if ($t->getNext()->checkNotClass(array('variable','_array'))) { return false; }

        $var = $t->getNext(1);
        while($var->checkOperator(',')) {
            if ($var->getNext()->checkNotClass(array('variable','_array'))) { return false; }
            $var = $var->getNext(1);
        }
        
        if ($var->checkNotOperator(';') &&
            $var->checkNotToken(T_CLOSE_TAG) &&
            $var->checkNotClass('rawtext')) {
            return false;
        }

        $var = $t;

        while($var->checkOperator(',') || $var->checkToken(T_GLOBAL)) {
        // @note registering a new global each comma
            $args = array(1);
            $remove = array(1);

            $repl = $var;
            $var = $var->getNext(1);

            $regex = new Cornac_Tokenizeur_Regex_Model('Cornac_Tokenizeur_Token_Global',$args, $remove);
            Cornac_Tokenizeur_Token::applyRegex($repl, 'Cornac_Tokenizeur_Token_Global', $regex);

            Cornac_Log::getInstance('tokenizer')->log(get_class($var)." => _global  (".$this->getTname().")");
            continue;
        }
        
        return false;
    }
}

?>
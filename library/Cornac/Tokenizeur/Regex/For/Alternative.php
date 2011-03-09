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

class Cornac_Tokenizeur_Regex_For_Alternative extends Cornac_Tokenizeur_Regex {
    protected $tname = 'for_alternative_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_FOR);
    }
    
    function check($t) {
        if (!$t->hasNext(4)) { return false; }

        if ($t->checkNotToken(T_FOR)) { return false; } 
        if ($t->getNext()->checkNotOperator('(')) { return false; } 
        
        $var = $t->getNext(1);
        while($var->checkNotCode(')')) {
            $var = $var->getNext();
            
            if (is_null($var)) { return false; }
        }
        
        $var = $var->getNext();        
        if ($var->checkNotCode(':')) { return false; } 

        $var = $var->getNext();
        $init = $var;
        
        $args = array();
        $remove = array(-1);
        $pos = 0;
 
         while($var->checkNotToken(T_ENDFOR)) {
            if ($var->checkForBlock()) {
                $args[] = $pos;
                $remove[] = $pos;
                if (!$var->hasNext()) { return $t; }
                $var = $var->getNext();
                $pos++;
                continue;
            }

            if ($var->checkNotClass(array('block','Token')) && 
                $var->getNext()->checkCode(';')) {
                $args[] = $pos;

                $remove[] = $pos;
                $remove[] = $pos + 1;
                if (!$var->hasNext(1)) { return $t; }
                $var = $var->getNext(1);
                $pos += 2;
                continue;
            }

            if ($var->checkToken(T_FOR) ) {
                // @note nested FOR? We'll process that later.
                $args = array();
                $remove = array();
                return false;
            }

            if ($var->checkOperator(';') ) {
                // @note trailing semi-colon ? Ignoring.
                $remove[] = $pos;
                $pos++;
                $var = $var->getNext();
                continue;
            }

            // @note couldn't figure it out? Aborting. 
            return false;
        }
        
        $remove[] = $pos;

        $regex = new Cornac_Tokenizeur_Regex_Model('block',$args, $remove);
        Cornac_Tokenizeur_Token::applyRegex($init, 'block', $regex);

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => block (".$this->getTname().")");
        return false; 
    }
}

?>
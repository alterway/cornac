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

class Cornac_Tokenizeur_Regex_Ifthen_Elsealternative extends Cornac_Tokenizeur_Regex {
    protected $tname = 'ifthenelse_alternative_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_ELSE);
    }
    
    function check($t) {
        if (!$t->hasNext(2) ) { return false; }

        if ($t->checkNotToken(array(T_ELSE))) { return false;} 
        if ($t->getNext()->checkNotOperator(':')) { return false; } 
        
        $args = array();
        $remove = array(-1 );
        $var = $t->getNext(1);            
        $pos = 0;

        while($var->checkNotToken(array(T_ENDIF))) {
           if ($var->checkToken(T_IF) ) {
              // @note antoher if starting? We don't handle nesting here.
              return false;
           }

            if ($var->checkForBlock()) {
                $args[] = $pos;
                $remove[] = $pos;
                if (!$var->hasNext()) { return $t; }
                $var = $var->getNext();
                $pos++;
                continue;
            }

            if ($var->checkNotClass(array('block','Token')) && 
                $var->getNext()->checkOperator(';')) {
                $args[] = $pos;

                $remove[] = $pos;
                $remove[] = $pos + 1;
                if (!$var->hasNext(1)) { return $t; }
                $var = $var->getNext(1);
                $pos += 2;
                continue;
            }

            if ($var->checkOperator(';') ) {
                // @note trailing semi-colon? just ignore this
                $remove[] = $pos;
                $pos++;
                $var = $var->getNext();
                continue;
            }

            // @note cannot process this? Abort. 
            return false;
        }

        if ($var->checkNotToken(T_ENDIF)) { return false; }
        $remove[] = $pos;

        $regex = new Cornac_Tokenizeur_Regex_Model('block',$args, $remove);
        Cornac_Tokenizeur_Token::applyRegex($t->getNext(1), 'block', $regex);

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => block (".$this->getTname().")");
        return false; 
    }
}
?>
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

class Cornac_Tokenizeur_Regex_Ifthen_Elseifalternative extends Cornac_Tokenizeur_Regex {
    protected $tname = 'ifthenelseif_alternative_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_IF,T_ELSEIF);
    }
    
    function check($t) {
        if (!$t->hasNext(2) ) { return false; }

        if (!$t->checkToken(array(T_IF,T_ELSEIF))) { return false;} 
        if ($t->getNext()->checkNotClass('parenthesis')) { return false; }
        if ($t->getNext(1)->checkNotOperator(':')) { return false; } 

        $args = array();
        $remove = array(0);
        $var = $t->getNext(2);            
        $pos = 0;

        while($var->checkNotToken(array(T_ENDIF,T_ELSEIF, T_ELSE))) {
            if ($var->checkToken(T_IF) ) {
                // @note another if starting? We don't handle nested here. aborting.
                return false;
            }

            if ($var->checkForBlock()) {
                $args[] = $pos + 1;
                $remove[] = $pos + 1;
                if (!$var->hasNext()) { return false; }
                $var = $var->getNext();
                $pos++;
                continue;
            }

            if ($var->checkNotClass(array('block','Token')) && 
                $var->getNext()->checkOperator(';')) {
                $args[] = $pos + 1;

                $remove[] = $pos + 1;
                $remove[] = $pos + 2;
                if (!$var->hasNext(1)) { return false; }
                $var = $var->getNext(1);
                $pos += 2;
                continue;
            }

            if ($var->checkOperator(';') ) {
                // @note trailing semi-colon. Bah...
                $remove[] = $pos + 1;
                $pos++;
                $var = $var->getNext();
                continue;
            }
            
            // @note none of the above? Forget it. 
            return false;
        }
        
        if ($var->checkToken(array( T_ELSE, T_ELSEIF))) { 
            // @note OK, we carry one. No need to remove anything
        } elseif ($var->checkToken(array( T_ENDIF))) {
            // @note must remove endif
            $remove[] = $pos + 1;
        } else {
            // @note just go away
            return false;  
        }

        $regex = new Cornac_Tokenizeur_Regex_Model('block',$args, $remove);
        Cornac_Tokenizeur_Token::applyRegex($t->getNext(1), 'block', $regex);

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => block (".$this->getTname().")");
        return false; 
    }
}
?>
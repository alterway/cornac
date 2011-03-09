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

class Cornac_Tokenizeur_Regex_Foreach_Alternative extends Cornac_Tokenizeur_Regex {
    protected $tname = 'foreach_alternative_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_FOREACH);
    }
    
    function check($t) {
        if (!$t->hasNext(6)) { return false; }

        if ($t->getNext()->checkNotOperator('(')) { return false; }
        if ($t->getNext(1)->checkNotClass(Cornac_Tokenizeur_Token_Foreach::$incoming_vars)) { return false; }
        if ($t->getNext(2)->checkNotToken(T_AS)) { return false; }
        
        $posi = 3;
        
        if ($t->getNext(3)->checkClass(array('variable','_array','property','reference'))  &&
            $t->getNext(4)->checkToken(T_DOUBLE_ARROW)) {
            $posi = 5;    
        }

        if ( $t->getNext($posi)->checkNotClass(array('variable','_array','property','reference'))  ||
             $t->getNext($posi + 1)->checkNotCode(')')) {
             return false;
        } 
        $posi += 2;
        if ($t->getNext($posi)->checkNotOperator(':')) { return false; }

        $args = array();
        $remove = array(-1);
        $pos = 0;
        $var = $t->getNext($posi + 1);
        
        while($var->checkNotToken(T_ENDFOREACH)) {
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

            if ($var->checkToken(T_FOREACH) ) {
                // @note nested foreach? We'll process this later
                return false;
            }
            
            if ($var->checkOperator(';') ) {
                // @note trailing semi-colon? Ignoring. 
                $remove[] = $pos;
                $pos++;
                $var = $var->getNext();
                continue;
            }

            // @note counldn't figure it out? Ignoring
            $this->args = array();
            $this->remove = array();
            return false;
        }
        
        $remove[] = $pos;

        $regex = new Cornac_Tokenizeur_Regex_Model('block',$args, $remove);
        Cornac_Tokenizeur_Token::applyRegex($t->getNext($posi+1), 'block', $regex);

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => block (".$this->getTname().")");
        return false; 
    }
}

?>
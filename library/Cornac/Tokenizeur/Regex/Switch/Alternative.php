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

class Cornac_Tokenizeur_Regex_Switch_Alternative extends Cornac_Tokenizeur_Regex {
    protected $tname = 'switch_alternative_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_SWITCH);
    }
    
    function check($t) {
        if (!$t->hasNext(2)) { return false; }

        if ($t->getNext()->checkNotClass('parenthesis')) { return false; }
        if ($t->getNext(1)->checkNotOperator(':')) { return false; }

        $pos = 0;
        $var = $t->getNext(2);
        
        $args = array();
        $remove = array();
        
        while($var->checkNotToken(T_ENDSWITCH)) {
            
            if ($var->checkClass('rawtext')) {
                $remove[] = $pos;
                $pos++;
                $var = $var->getNext();
                continue;
            }
            if ($var->checkNotClass(array('_case','_default'))) { return false; }
            
            $args[] = $pos;
            $remove[] = $pos;
            $pos++;
            
            $var = $var->getNext();
        }
        
        $regex = new Cornac_Tokenizeur_Regex_Model('block',$args, $remove);
        Cornac_Tokenizeur_Token::applyRegex($t->getNext(2), 'block', $regex);

        $this->args = array(1, 3);
        $this->remove = array(1, 2, 3, 4);
        
        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true; 
    }
}
?>
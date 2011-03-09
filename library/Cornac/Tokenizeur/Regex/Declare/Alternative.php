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

class Cornac_Tokenizeur_Regex_Declare_Alternative extends Cornac_Tokenizeur_Regex {
    protected $tname = 'declare_alternative_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_DECLARE);
    }
 
    
    function check($t) {
        if (!$t->hasNext()) { return false; }
        
        if ($t->getNext()->checkClass('parenthesis') && 
            $t->getNext(1)->checkOperator(':')) {
            $this->args = array(1, 3);
            $this->remove = array(1, 2, 3);

            $var = $t->getNext(2);
            $init = $var;
            
            $args = array();
            $remove = array(-1);
            $pos = 0;

        } elseif ($t->getNext()->checkOperator('(') && 
            $t->getNext(1)->checkClass('affectation') &&
            $t->getNext(2)->checkOperator(',') &&
            $t->getNext(3)->checkClass('affectation') &&
            $t->getNext(4)->checkOperator(')') && 
            $t->getNext(5)->checkOperator(':') 
            ) {            
            $this->args = array(2,4, 6);
            $this->remove = array(1,2,3,4,5, 6);

            $var = $t->getNext(6);
            $init = $var;
            
            $args = array();
            $remove = array(-1);
            $pos = 0;
        } else {
            return false;
        }
        

         while($var->checkNotToken(T_ENDDECLARE)) {
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

            if ($var->checkOperator(';') ) {
                // @note trailing semi-colon : just ignore it
                $remove[] = $pos;
                $pos++;
                $var = $var->getNext();
                continue;
            }

            // @note coun't figure this out? Aborting.
            return false;
         }

        $remove[] = $pos;

        $regex = new Cornac_Tokenizeur_Regex_Model('block',$args, $remove);
        Cornac_Tokenizeur_Token::applyRegex($init, 'block', $regex);
        
        $this->args[] = 

        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => block (".$this->getTname().")");
        return true;
    }
}
?>
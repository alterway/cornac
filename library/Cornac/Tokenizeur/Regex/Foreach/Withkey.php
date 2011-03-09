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

class Cornac_Tokenizeur_Regex_Foreach_Withkey extends Cornac_Tokenizeur_Regex {
    protected $tname = 'foreach_withkey_regex';

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
        if ($t->getNext(3)->checkNotClass(Cornac_Tokenizeur_Token_Foreach::$blind_keys)) { return false; }
        if ($t->getNext(4)->checkNotToken(T_DOUBLE_ARROW)) { return false; }
        if ($t->getNext(5)->checkNotClass(Cornac_Tokenizeur_Token_Foreach::$blind_values)) { return false; }
        if ($t->getNext(6)->checkNotCode(')')) { return false; }

        if ($t->getNext(7)->checkClass(array('block','sequence'))) {
          $this->args = array(2, 4, 6, 8);
          $this->remove = array(1,2,3,4,5,6,7,8);

          Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
          return true;
        } elseif ($t->getNext(7)->checkForBlock()) {
            if ($t->getNext(8)->checkForAssignation()) {return false; }

            $regex = new Cornac_Tokenizeur_Regex_Model('block',array(0), array());
            Cornac_Tokenizeur_Token::applyRegex($t->getNext(7), 'block', $regex);

            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => block (".$this->getTname().")");
            return false; 
        } elseif ($t->getNext(7)->checkCode(';')) {
          $this->args = array(2, 4, 6, 8);
          $this->remove = array(1,2,3,4,5,6,7,8);
            
            Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => no block ".$this->getTname());
            return true;
        } else {
            return false;
        }
    }
}

?>
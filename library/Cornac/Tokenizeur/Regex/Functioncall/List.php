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

class Cornac_Tokenizeur_Regex_Functioncall_List extends Cornac_Tokenizeur_Regex {
    protected $tname = 'functioncall_list_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_LIST);
    }

    function check($t) {
        if (!$t->hasNext() ) { return false; }

        if ($t->checkNotToken(T_LIST)) { return false; }
        if ($t->getNext()->checkNotCode('(')) { return false; }
        if ($t->getNext()->checkClass('arglist')) { return false; }

        $args = array();
        $remove = array(0);
        
        $var = $t->getNext(1);
        $pos = 1;
        
        while($var->checkNotCode(')')) {
            if ($var->checkClass(array('variable','_array','property','property_static'))) {
                $args[] = $pos;
                $remove[] = $pos;                
                
                $pos += 1;
                $var = $var->getNext();
                if (is_null($var)) {
                    return false;
                }
                continue;
            }

            if ($var->checkCode(',')) {
                if ($var->getPrev()->checkCode(array(',','('))) {
                    $args[] = $pos;
                }
                $remove[] = $pos;                
                
                $pos += 1;
                $var = $var->getNext();
                if (is_null($var)) {
                    return false;
                }
                continue;
            }
            
            return false;
        }
        $remove[] = $pos;
        
        $regex = new Cornac_Tokenizeur_Regex_Model('arglist',$args, $remove);
        Cornac_Tokenizeur_Token::applyRegex($t->getNext(), 'arglist', $regex);
        
        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return false; 
    }
}
?>
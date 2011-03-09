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

class Cornac_Tokenizeur_Regex_Interface extends Cornac_Tokenizeur_Regex {
    protected $tname = 'interface_normal_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_INTERFACE );
    }
    
    function check($t) {
        if (!$t->hasNext(1)) { return false; }
        if ($t->checkNotToken(T_INTERFACE)) { return false; } 

        $this->args = array(1);
        $this->remove = array(1);
        
        $pos = 1;
        $var = $t->getNext(1);
        if ($var->checkToken(T_EXTENDS)) {
            $this->args[] = $pos + 2;
            $this->remove[] = $pos + 1;
            $this->remove[] = $pos + 2;

            $var = $var->getNext(1);
            $pos = $pos + 2;

            while ($var->checkCode(',')) {
                $this->args[] = $pos + 2;
                $this->remove[] = $pos + 1;
                $this->remove[] = $pos + 2;

                $var = $var->getNext(1);
                $pos = $pos + 2;
            }
        }
        
        if ($var->checkNotClass('block')) { return false; } 

        $this->args[] = $pos + 1;
        $this->remove[] = $pos + 1;
        
        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true; 
    }
}
?>
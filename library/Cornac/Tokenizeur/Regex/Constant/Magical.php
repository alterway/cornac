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

class Cornac_Tokenizeur_Regex_Constant_Magical extends Cornac_Tokenizeur_Regex {
    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array(T_FILE, T_DIR, T_CLASS_C, T_LINE, T_METHOD_C, T_FUNC_C, T_NS_C);
    }
    
    function check($t) {
    // @note getTokens also checks for code value, not only token. 
        if ($t->checkNotToken(array(T_FILE, T_DIR, T_CLASS_C, T_LINE, T_METHOD_C, T_FUNC_C, T_NS_C))) { return false; }
        
        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true; 
    }
}
?>
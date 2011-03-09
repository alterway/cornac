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

class Cornac_Tokenizeur_Regex_Variable_Separatedcurly extends Cornac_Tokenizeur_Regex {
    protected $tname = 'variable_separatedcurly_regex';

    function __construct() {
        parent::__construct(array());
    }

    function getTokens() {
        return array('$');
    }
    
    function check($t) {
        if (!$t->hasNext(3) ) { return false; }
        
        if ($t->getNext()->checkNotCode('{')) { return false;}
        if ($t->getNext(1)->checkClass('Token')) { return false;}
        if ($t->getNext(2)->checkNotCode('}')) { return false;}
        
        $this->args   = array(1, 2);
        $this->remove = array(1,2,3);

        return true;
    }
}
?>
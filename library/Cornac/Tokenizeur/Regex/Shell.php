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

class Cornac_Tokenizeur_Regex_Shell extends Cornac_Tokenizeur_Regex {
    protected $tname = 'shell_normal_regex';

    function __construct() {
        parent::__construct(array());
        
        $this->sequence_classes = array('literals',
                                        'variable',
                                        '_array',
                                        'property',
                                        'property_static',
                                        'method',
                                        'method_static',
                                        'constant_static',
                                        'sequence',
                                        );
    }

    function getTokens() {
        return array('`');
    }
 
    function check($t) {
        if (!$t->hasNext() ) { return false; }

        if ($t->checkNotOperator('`')) { return false; } 
        
        if ($t->checkOperator('`') ) {
            $token_fin = '`';
        } else {
            return false;
        }

        $var = $t->getNext(); 
        $this->args   = array(  );
        $this->remove = array(  );
        $pos = 1;
        
        while ($var->checkNotOperator($token_fin)) {
            if ($var->checkOperator('{') && 
                $var->getNext()->checkClass($this->sequence_classes) && 
                  $var->getNext(1)->checkOperator('}')) {

                $regex = new Cornac_Tokenizeur_Regex_Model('variable',array(0), array(-1, 1));
                Cornac_Tokenizeur_Token::applyRegex($var->getNext(), 'variable', $regex);

                Cornac_Log::getInstance('tokenizer')->log(get_class($var->getNext())." => ".get_class($var->getNext())." (".$this->getTname().")");
                return false;
            }

            if ($var->checkNotClass($this->sequence_classes) &&
                $var->checkNotClass('sign')) { return false; }
        
            $this->args[]    = $pos;
            $this->remove[]  = $pos;

            $pos += 1;
            $var = $var->getNext();
            if (is_null($var)) { return false; }
        }

        $this->remove[]  = $pos; // @note final "
        
        Cornac_Log::getInstance('tokenizer')->log(get_class($t)." => ".$this->getTname());
        return true; 
    }
}
?>
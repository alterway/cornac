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

class Cornac_Tokenizeur_Token_Sequence extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = 'sequence';
    protected $elements = array();
    
    function __construct($expression = array()) {
        parent::__construct(array());
        
        foreach($expression as $l) {
            if ($l->checkClass('sequence')) {
                $this->elements = array_merge($this->elements, $l->getElements());
            } elseif ($l->checkClass('block')) {
                $this->elements = array_merge($this->elements, $l->getList());
            } elseif ($l->checkClass('codephp')) {
                $code = $l->getphp_code();
                if ($l->checkClass('sequence')) {
                    $this->elements = array_merge($this->elements, $code->getElements());
                } else {
                    $this->elements[] = $code;
                }
            } else {
                $this->elements[] = $l;
            }
         }
    }

    function __toString() {
        $return = $this->getTname();
        if (count($this->elements) == 0) {
        // @note this shouldn't happen...
            $return .= "Empty Sequence\n";
        } else {
            foreach($this->elements as $e) {
                $return .= $e."\n";
            }
        }
        return $return;
    }

    function getCode() {
        return $this->getTname();
    }
    
    function getElements() {
        return $this->elements;
    }

    function neutralise() {
        foreach($this->elements as $e) {
            $e->detach();
        }
    }

    public function getRegex() {
        return array(
          'Cornac_Tokenizeur_Regex_Sequence_Simple',
          'Cornac_Tokenizeur_Regex_Sequence_Suite',
          'Cornac_Tokenizeur_Regex_Sequence_Class',
          'Cornac_Tokenizeur_Regex_Sequence_Empty',
          'Cornac_Tokenizeur_Regex_Sequence_Cdr',
                    );
    }    
}

?>
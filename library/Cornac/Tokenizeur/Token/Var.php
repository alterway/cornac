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

class Cornac_Tokenizeur_Token_Var extends Cornac_Tokenizeur_Token_Instruction {
    protected $tname = '_var';
    protected $_static = null;
    protected $_visibility = null;
    protected $variable = array();
    protected $init = array();

    function __construct($expression) {
        parent::__construct(array());

        switch($expression[0]->getToken()) {
            case T_VAR: 
                $expression[0]->setCode('var');
                $this->_visibility = $this->makeProcessed('_ppp_', $expression[0]);
                break 1;

            case T_VAR + T_STATIC : 
                $expression[0]->setCode('var');
                $expression[0]->setToken(T_VAR);
                $this->_visibility = $this->makeProcessed('_ppp_', $expression[0]);
                $expression[0]->setCode('static');
                $expression[0]->setToken(T_STATIC);
                $this->_static = $this->makeProcessed('_static_', $expression[0]);
                break 1;

            case T_PUBLIC: 
                $expression[0]->setCode('public');
                $this->_visibility = $this->makeProcessed('_ppp_', $expression[0]);
                break 1;

            case T_PUBLIC + T_STATIC : 
                $expression[0]->setCode('public');
                $expression[0]->setToken(T_PUBLIC);
                $this->_visibility = $this->makeProcessed('_ppp_', $expression[0]);
                $expression[0]->setCode('static');
                $expression[0]->setToken(T_STATIC);
                $this->_static = $this->makeProcessed('_static_', $expression[0]);
                break 1;

            case T_PROTECTED: 
                $expression[0]->setCode('protected');
                $this->_visibility = $this->makeProcessed('_ppp_', $expression[0]);
                break 1;

            case T_PROTECTED + T_STATIC : 
                $expression[0]->setCode('protected');
                $expression[0]->setToken(T_PROTECTED);
                $this->_visibility = $this->makeProcessed('_ppp_', $expression[0]);
                $expression[0]->setCode('static');
                $expression[0]->setToken(T_STATIC);
                $this->_static = $this->makeProcessed('_static_', $expression[0]);
                $this->setToken(T_PROTECTED);
                break 1;

            case T_PRIVATE: 
                $expression[0]->setCode('private');
                $this->_visibility = $this->makeProcessed('_ppp_', $expression[0]);
                break 1;

            case T_PRIVATE + T_STATIC : 
                $expression[0]->setCode('private');
                $expression[0]->setToken(T_PRIVATE);
                $this->_visibility = $this->makeProcessed('_ppp_', $expression[0]);
                $expression[0]->setCode('static');
                $expression[0]->setToken(T_STATIC);
                $this->_static = $this->makeProcessed('_static_', $expression[0]);
                break 1;

            default : 
                print $expression[0];
                $this->stopOnError(" Unexpected token for ".$expression[0]->getToken()." : ".get_class($expression[0])." in ".__METHOD__);
        }

        unset($expression[0]);
        $expression = array_values($expression);

        foreach($expression as $id => $e) {
            if ($e->checkClass('variable')) {
                $this->variable[] = $e;
                $this->init[] = null;
            } elseif ($e->checkClass('affectation')) {
                $this->variable[] = $e->getLeft();
                $this->init[] = $e->getRight();
            } else {
                $this->stopOnError(" Unexpected class for ".$this->getTname()." : ".get_class($e)." $e $id in ".__METHOD__);
            }
        }
    }
    
    function __toString() {
         $return = $this->getTname()." ".$this->getVisibility();
         
         $r = array();
         foreach($this->variable as $id => $variable) {
            $r[] = $variable;
         }
         $return .= join(', ', $r);
         return $return;
    }

    function getVariable() {
        return $this->variable;
    }

    function getInit() {
        return $this->init;
    }

    function getVisibility() {
        return $this->_visibility;
    }

    function getStatic() {
        return $this->_static;
    }

    function neutralise() {
        if (count($this->variable)) {
            foreach($this->variable as $id => $e) {
                $e->detach();
                if (!is_null($this->init[$id])) {
                    $this->init[$id]->detach();
                }
            }
        }
        if (!is_null($this->_static)) {
            $this->_static->detach();
        }
        if (!is_null($this->_visibility)) {
            $this->_visibility->detach();
        }
    }

    function getRegex() {
        return array(
                      'Cornac_Tokenizeur_Regex_Var_Simple',
                    );
    }
}

?>